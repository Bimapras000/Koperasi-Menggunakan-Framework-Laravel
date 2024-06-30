<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    //
    // public function index(Request $request)
    // {
    //     $users = User::all();
    //     $nama = $request->input('name');
        
    //     $pinjaman = Peminjaman::where('konfirmasi', Peminjaman::STATUS_APPROVED)->paginate(10);
    //     if ($nama) { 
    //         $peminjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
    //             ->select('peminjaman.*', 'users.name as nama')
    //             ->where('users.name', 'like', '%'.$nama.'%')
    //             ->paginate(4);
    //         if ($peminjaman->isEmpty()) {
    //             return view('admin.peminjaman.index', compact('peminjaman', 'users'))
    //                 ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
    //         }
    //     } else {
    //         $peminjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
    //             ->select('peminjaman.*', 'users.name as nama')
    //             ->paginate(4);
    //     }

    //     return view('admin.peminjaman.index', compact('peminjaman', 'users'));
    // }
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
            
            'nominal' => 'required|numeric',

        ]);

        // Hitung total dengan bunga 2% per bulan
        // $tanggalPinjaman = new \DateTime($request->tgl_pinjaman);
        // $tanggalPengembalian = new \DateTime($request->tgl_pengembalian);
        // $interval = $tanggalPinjaman->diff($tanggalPengembalian);
        // $jumlahBulan = ($interval->y * 12) + $interval->m + ($interval->d > 0 ? 1 : 0);

        // $bungaPerBulan = $request->nominal * 0.02;
        // $totalBunga = $bungaPerBulan * $jumlahBulan;
        // $total = $request->nominal + $totalBunga;

        Peminjaman::create([
            'users_id' => $request->users_id,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'keperluan' => $request->keperluan,
            'nominal' => $request->nominal,
            'tgl_pinjaman' => $request->tgl_pinjaman,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'bunga' => 2, // Bunga 2% per bulan
            'total' => $request->total,
            'status' => 'Belum Lunas',
            'konfirmasi' => Peminjaman::STATUS_PENDING, // Set status to pending


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
                ->paginate(4);
            if ($pinjaman->isEmpty()) {
                return view('admin.peminjaman.index', compact('peminjaman', 'users'))
                    ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
            }
        } else {
            $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
                ->select('peminjaman.*', 'users.name as nama')
                ->paginate(4);
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



}
