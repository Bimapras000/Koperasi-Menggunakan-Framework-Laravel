<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Peminjaman;
use App\Models\Setor;
use Carbon\Carbon;
use Auth;
use DB;
use PDF;

class UserController extends Controller
{
    //
    public function index()
{
    $user = Auth::user();
    // Menghitung jumlah pinjaman yang sudah dikonfirmasi
    $jumlahPeminjaman = $user->peminjaman()->where('konfirmasi', \App\Models\Peminjaman::STATUS_APPROVED)->sum('total');
    $setoranMingguIni = $user->setor()->where('tgl_setor', '>=', now()->startOfWeek())->sum('nominal');
    $totalTabungan = $user->tabungan()->sum('saldo');
    $transaksiSetoranTerakhir = $user->setor()->orderBy('tgl_setor', 'desc')->take(10)->get();

    return view('user.dashboarduser', compact('jumlahPeminjaman', 'setoranMingguIni', 'totalTabungan', 'transaksiSetoranTerakhir'));
}


    public function tabunganIndex(Request $request)
    {
        
        $user = Auth::user();
        $tabungan = $user->tabungan; // Mengambil data tabungan yang terkait dengan user yang login
        $riwayat = $user->setor()->where('jenis_setor', 'menabung')->get(); // Mengambil data setoran dengan jenis menabung

        return view('user.tabunganuser', compact('tabungan','riwayat'));
    }

    public function setorIndex()
    {
        $userId = Auth::id();
        $setor = Setor::where('users_id', $userId)->paginate(10);

        return view('user.setoruser', compact('setor'));
    }

    // public function create()
    // {
    //     //
    //     return view('user.setoruser');
    // }

//     public function store(Request $request)
// {
//     $request->validate([
//         'nominal' => 'required|min:50000',
//         'tgl_setor' => 'required|date',
//         'jenis_setor' => 'required|string',
//         'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//     ]);

//     try {
//         $setoran = new Setor();
//         $setoran->users_id = Auth::id();
//         // Menghapus titik dan koma dari input nominal
//         $nominal = str_replace(['.', ','], '', $request->nominal);
//         $setoran->nominal;
//         $setoran->tgl_setor = $request->tgl_setor;
//         $setoran->jenis_setor = $request->jenis_setor;

//         if ($request->hasFile('bukti_foto')) {
//             $file = $request->file('bukti_foto');
//             $filename = time() . '.' . $file->getClientOriginalExtension();
//             $file->move(public_path('storage/fotos_bukti/'), $filename);
//             $setoran->bukti_foto = $filename;
//         }
//         $setoran->konfirmasi = Setor::STATUS_PENDING;

//         // Jika jenis setor adalah cicilan
//         if ($request->jenis_setor == 'Cicilan') {
//             $this->prosesCicilan(Auth::id(), ($nominal));
//         }

//         $setoran->save();

//         return redirect()->route('setor.index')->with('success', 'Setoran berhasil ditambahkan.');
//     } catch (\Exception $e) {
//         Log::error('Error saat menyimpan setoran: ' . $e->getMessage());
//         return back()->withErrors('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
//     }
// }

// private function prosesCicilan($userId, $totalNominal)
// {
//     // Cari pinjaman aktif dari user
//     $peminjaman = Peminjaman::where('users_id', $userId)
//                             ->where('status', 'Belum Lunas')
//                             ->first();

//     if ($peminjaman) {
//         // Kurangi total nominal pinjaman dengan jumlah setor
//         $peminjaman->total -= $totalNominal;

//         // Jika total nominal pinjaman sudah lunas
//         if ($peminjaman->total <= 0) {
//             $peminjaman->status = 'Lunas';
//             $peminjaman->total = 0; // Mengatur total menjadi nol jika lunas
//         }

//         $peminjaman->save();
//     }
// }
public function store(Request $request)
{
    // Pastikan user terotentikasi
    $userId = Auth::id();

    // Validasi input
    $request->validate([
        'nominal' => 'required|regex:/^\d{1,3}(\.\d{3})*(,\d+)?$/',
        'jenis_setor' => 'required|max:20',
        'tgl_setor' => 'required|date',
        'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    ], [
        'nominal.required' => 'Nominal wajib diisi',
        'nominal.regex' => 'Format nominal tidak valid',
        'jenis_setor.required' => 'Jenis Setor wajib diisi',
        'tgl_setor.required' => 'Tanggal Setor wajib diisi',
        'tgl_setor.date' => 'Tanggal Setor harus berupa tanggal yang valid',
        'bukti_foto.max' => 'Foto maksimal 2 MB',
        'bukti_foto.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',
    ]);

    // Proses file bukti_foto
    if ($request->hasFile('bukti_foto')) {
        $file = $request->file('bukti_foto');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('storage/fotos_bukti/'), $fileName);
    } else {
        $fileName = null;
    }

    $totalNominal = str_replace(['.', ','], '', $request->nominal);

    // Validasi minimal nominal setelah format
    if ($totalNominal < 50000) {
        return redirect()->back()->withErrors(['nominal' => 'Nominal minimal adalah Rp. 50.000'])->withInput();
    }

    // Insert ke tabel setor
    DB::table('setor')->insert([
        'users_id' => $userId,
        'nominal' => $totalNominal,
        'jenis_setor' => $request->jenis_setor,
        'tgl_setor' => $request->tgl_setor,
        'bukti_foto' => $fileName,
        'konfirmasi' => Setor::STATUS_PENDING,
    ]);

    // Jika jenis setor adalah cicilan
    if ($request->jenis_setor == 'Cicilan') {
        $this->prosesCicilan($userId, $totalNominal);
    }

    // Redirect user ke halaman yang sesuai
    return redirect()->route('anggota.setor')->with('success', 'Berhasil Menambahkan Setoran');
}

private function prosesCicilan($userId, $totalNominal)
{
    // Cari pinjaman aktif dari user
    $peminjaman = Peminjaman::where('users_id', $userId)
                            ->where('status', 'Belum Lunas')
                            ->first();

    if ($peminjaman) {
        // Kurangi total nominal pinjaman dengan jumlah setor
        $peminjaman->total -= $totalNominal;

        // Jika total nominal pinjaman sudah lunas
        if ($peminjaman->total <= 0) {
            $peminjaman->status = 'Lunas';
            $peminjaman->total = 0; // Mengatur total menjadi nol jika lunas
        }

        $peminjaman->save();
    }
}





    public function showInvoice($id)
{
    $setor = Setor::join('users', 'users.id', '=', 'setor.users_id')
        ->select('setor.*', 'users.name as nama', 'users.alamat', 'users.no_tlp')
        ->where('setor.id', $id)
        ->first();

    if (!$setor) {
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    // Generate invoice code
    $date = \Carbon\Carbon::now();
    $invoiceCode = $date->format('dmY') . '-' . $setor->id;

    return view('user.invoice_content', compact('setor', 'invoiceCode'));
}

public function downloadInvoicePDF($id)
{
    $setor = Setor::join('users', 'users.id', '=', 'setor.users_id')
        ->select('setor.*', 'users.name as nama', 'users.alamat', 'users.no_tlp')
        ->where('setor.id', $id)
        ->first();

    if (!$setor) {
        return redirect('user/setoruser')->with('error', 'Data tidak ditemukan');
    }

    // Generate invoice code
    $date = \Carbon\Carbon::now();
    $invoiceCode = $date->format('dmY') . '-' . $setor->id;

    $pdf = PDF::loadView('user.invoice_content', compact('setor', 'invoiceCode'))->setPaper('a4', 'landscape');
    return $pdf->download('invoice-' . $invoiceCode . '.pdf');
}

    public function pinjamanindex(Request $request)
    {
        $user = Auth::user();
        $nama = $request->input('name');

        $query = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
                            ->select('peminjaman.*', 'users.name as nama')
                            ->where('peminjaman.konfirmasi', Peminjaman::STATUS_APPROVED);

        if ($nama) {
            $query = $query->where('users.name', 'like', '%' . $nama . '%');
        }

        $peminjaman = $query->where('users.id', $user->id)->paginate(10);

        if ($peminjaman->isEmpty() && $nama) {
            return view('user.peminjaman.index', compact('peminjaman'))
                    ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
        }

        return view('user.pinjamanuser', compact('peminjaman'));
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

        return view('user.show', compact('peminjaman', 'user', 'monthlyPayment'));
    }

    public function create1()
    {
        $user = Auth::user();
        return view('user.peminjamn', compact('user'));
    }

    public function store1(Request $request)
{
    $request->validate([
        'keperluan' => 'required',
        'tgl_pinjaman' => 'required|date',
        'tgl_pengembalian' => 'required|date|after_or_equal:tgl_pinjaman',
        'nominal' => 'required',
    ]);

    $user = Auth::user();
    $existingLoan = Peminjaman::where('users_id', $user->id)
                            ->where('status', 'Belum Lunas')
                            ->first();

    if ($existingLoan) {
        return redirect()->back()->withInput()->withErrors(['error' => 'Anda tidak dapat melakukan pinjaman baru sebelum pinjaman sebelumnya lunas.']);
    
    }

    Peminjaman::create([
        'users_id' => $user->id,
        'alamat' => $user->alamat,
        'keperluan' => $request->keperluan,
        'nominal' => $request->nominal,
        'tgl_pinjaman' => $request->tgl_pinjaman,
        'tgl_pengembalian' => $request->tgl_pengembalian,
        'bunga' => 2, // Bunga 2% per bulan
        'total' => $request->total,
        'status' => 'Belum Lunas',
        'konfirmasi' => Peminjaman::STATUS_PENDING, // Set status to pending
    ]);

    return redirect('user/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan');
}

//     public function store1(Request $request)
// {
//     // Cek apakah pengguna memiliki peminjaman yang belum lunas
//     $user = Auth::user();
//     $peminjamanAktif = Peminjaman::where('users_id', $user->id)->where('status', 'Belum Lunas')->first();

//     if ($peminjamanAktif) {
//         return redirect()->back()->withErrors(['error' => 'Anda masih memiliki peminjaman yang belum lunas.'])->withInput();
//     }

//     // Validasi input
//     $request->validate([
//         'keperluan' => 'required',
//         'tgl_pinjaman' => 'required|date',
//         'tgl_pengembalian' => 'required|date|after_or_equal:tgl_pinjaman',
//         'nominal' => 'required|numeric',
//     ]);

//     // Hitung bunga dan total pinjaman
//     $bunga = 2; // Bunga 2% per bulan
//     $total = $request->nominal + ($request->nominal * ($bunga / 100));

//     // Buat peminjaman baru
//     Peminjaman::create([
//         'users_id' => $user->id,
//         'alamat' => $user->alamat,
//         'keperluan' => $request->keperluan,
//         'nominal' => $request->nominal,
//         'tgl_pinjaman' => $request->tgl_pinjaman,
//         'tgl_pengembalian' => $request->tgl_pengembalian,
//         'bunga' => $bunga,
//         'total' => $total,
//         'status' => 'Belum Lunas',
//         'konfirmasi' => Peminjaman::STATUS_PENDING, // Set status to pending
//     ]);

//     return redirect('user/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan');
// }


    public function riwayat(Request $request)
{
    $user = Auth::user(); // Mendapatkan pengguna yang sedang login
    $nama = $request->input('name');
    
    if ($nama) { 
        $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
            ->select('peminjaman.*', 'users.name as nama')
            ->where('users.id', '=', $user->id) // Filter berdasarkan pengguna yang sedang login
            ->where('users.name', 'like', '%'.$nama.'%')
            ->paginate(10);
        if ($pinjaman->isEmpty()) {
            return view('user.riwayatpeminjaman', compact('pinjaman'))
                ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
        }
    } else {
        $pinjaman = Peminjaman::join('users', 'users.id', '=', 'peminjaman.users_id')
            ->select('peminjaman.*', 'users.name as nama')
            ->where('users.id', '=', $user->id) // Filter berdasarkan pengguna yang sedang login
            ->paginate(10);
    }

    return view('user.riwayatpeminjaman', compact('pinjaman'));
}

public function riwayatTabungan(Request $request)
{
    $tabunganId = $request->input('id');
    $riwayat = Tabungan::where('id', $tabunganId)->first()->riwayat; // Sesuaikan dengan model dan relasi Anda

    return view('user.riwayat_tabungan', compact('riwayat'));
}


}





