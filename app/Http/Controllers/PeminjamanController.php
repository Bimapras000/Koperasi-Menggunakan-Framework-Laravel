<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PeminjamanController extends Controller
{
    //
    
    public function index(Request $request)
{
    $users = User::all();
    $nama = $request->input('name');
    
    $query = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
                        ->select('peminjaman.*', 'users.name as nama')
                        ->where('peminjaman.konfirmasi', Peminjaman::STATUS_APPROVED);

    if ($nama) {
        $query = $query->where('users.name', 'like', '%' . $nama . '%');
    }

    $peminjaman = $query->paginate(10);

    if ($peminjaman->isEmpty() && $nama) {
        return view('admin.peminjaman.index', compact('peminjaman', 'users'))
                ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
    }

    return view('admin.peminjaman.index', compact('peminjaman', 'users'));
}


    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $user = User::findOrFail($peminjaman->users_id);

        // Calculate monthly payment
        $tanggalPinjaman = new \DateTime($peminjaman->tgl_pinjaman);
        $tanggalPengembalian = new \DateTime($peminjaman->tgl_pengembalian);
        $interval = $tanggalPinjaman->diff($tanggalPengembalian);
        $jumlahBulan = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);

        $bungaPerBulan = $peminjaman->nominal * 0.02;
        $totalBunga = $bungaPerBulan * $jumlahBulan;
        $total = $peminjaman->nominal + $totalBunga;
        $monthlyPayment = $total / $jumlahBulan;

        return view('admin.peminjaman.show', compact('peminjaman', 'user', 'monthlyPayment'));
    }

    public function create()
    {
        $users = User::where('jabatan', 'anggota')->orWhere('jabatan', 'petugas')->get();
        return view('admin.peminjaman.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keperluan' => 'required',
            'tgl_pinjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date|after_or_equal:tgl_pinjaman',
            
            'nominal' => 'required',

        ]);

        $nominal = str_replace('.', '', $request->nominal); // Hapus pemisah ribuan jika ada
    
        $tglPinjaman = new \DateTime($request->tgl_pinjaman);
        $tglPengembalian = new \DateTime($request->tgl_pengembalian);
        $diff = $tglPinjaman->diff($tglPengembalian);
        $diffMonths = $diff->m + ($diff->y * 12);
    
        $bunga = 2; // Bunga 2% per bulan
        $total = $nominal + ($nominal * ($bunga / 100) * $diffMonths);
    
        Peminjaman::create([
            'users_id' => $request->users_id,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'keperluan' => $request->keperluan,
            'nominal' => $nominal,
            'tgl_pinjaman' => $request->tgl_pinjaman,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'bunga' => $bunga, 
            'total' => $total,
            'status' => 'Belum Lunas',
            'konfirmasi' => Peminjaman::STATUS_PENDING,
        ]);

        return redirect('admin/riwayat')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function riwayat(Request $request)
    {
        $users = User::all();
        $nama = $request->input('name');
        
        if ($nama) { 
            $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
                ->select('peminjaman.*', 'users.name as nama')
                ->where('users.name', 'like', '%'.$nama.'%')
                ->paginate(10);
            if ($pinjaman->isEmpty()) {
                return view('admin.peminjaman.index', compact('peminjaman', 'users'))
                    ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
            }
        } else {
            $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
                ->select('peminjaman.*', 'users.name as nama')
                ->paginate(10);
        }

        return view('admin.peminjaman.riwayat', compact('pinjaman', 'users'));
    }
    
    public function konfirmasiIndex()
{
    // $peminjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
    // ->select('peminjaman.*', 'users.name as nama', 'users.alamat as alamatt','users.no_tlp as tlp')
    // ->get();
    // $pinjaman = Peminjaman::where('konfirmasi', Peminjaman::STATUS_PENDING)->get();

    $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
    ->select('peminjaman.*', 'users.name as nama', 'users.alamat as alamatt', 'users.no_tlp as tlp')
    ->where('peminjaman.konfirmasi', Peminjaman::STATUS_PENDING)
    ->get();

    return view('admin.peminjaman.konfirmasi', compact('pinjaman'));
}

public function konfirmasi($id)
{
    $pinjaman = Peminjaman::find($id);
    if ($pinjaman) {
        $pinjaman->konfirmasi = Peminjaman::STATUS_APPROVED;
        $pinjaman->save();
    }

    return redirect('/admin/konfirmasi1')->with('success', 'Peminjaman Berhasil Dikonfirmasi');
}

public function processTolak(Request $request, $id)
{
    $request->validate([
        'alasan' => 'required|string|max:255',
    ]);

    $pinjaman = Peminjaman::findOrFail($id);
    $pinjaman->konfirmasi = Peminjaman::STATUS_REJECTED;
    $pinjaman->alasan = $request->alasan;
    $pinjaman->save();

    return redirect('/admin/konfirmasi1')->with('success', 'Peminjaman Berhasil Ditolak');
}


public function alasanForm($id)
{
    $pinjaman = Peminjaman::findOrFail($id); // Ambil data peminjaman berdasarkan ID
    return view('admin.peminjaman.alasan_tolak', compact('pinjaman'));
}

public function peminjamanPDF(){
    // $anggota = User::get();
    // if ($anggota->isEmpty()) {
    //     return 'No data found';
    // }
    // $pdf = PDF::loadView('admin.anggota.anggotaPDF', ['anggota' => $anggota])->setPaper('a4', 'landscape');
    // return $pdf->stream();
    // Mengambil semua data peminjaman yang sudah dikonfirmasi
    $peminjaman = Peminjaman::all();

    // Generate PDF dengan data peminjaman
    $pdf = PDF::loadView('admin.peminjaman.peminjamanPDF', compact('peminjaman'))->setPaper('a4', 'landscape');
    return $pdf->stream('peminjaman.pdf');

}

public function exportpeminjamanExcel()
{
    return Excel::download(new PeminjamanExport, 'Peminjaman.xlsx');
}

}
