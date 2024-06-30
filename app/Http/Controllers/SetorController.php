<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetorController extends Controller
{
    //
    // public function index(Request $request)
    // {
    //     //
    //     $users = User::all();
    //     $nama = $request->input('name'); // Mengambil nilai dari input 'name'
    
    //     if ($nama) { 
    //         $setor = Setor::join('users', 'users.id', '=', 'setor.users_id')
    //             ->select('setor.*', 'users.name as nama')
    //             ->where('users.name', 'like', '%'.$nama.'%')
    //             ->paginate(4);
    //         if ($setor->isEmpty()) {
    //             return view('admin.setor.index', compact('setor', 'users'))
    //                 ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
    //         }
    //     } else {
    //         $setor = Setor::join('users', 'users.id', '=', 'setor.users_id')
    //             ->select('setor.*', 'users.name as nama')
    //             ->paginate(4);
    //     }

    //     return view('admin.setor.index', compact('setor', 'users'));


    // }
    public function index(Request $request)
{
    $users = User::all();
    $nama = $request->input('name'); // Mengambil nilai dari input 'name'

    // Query data setoran dengan mengurutkan berdasarkan tanggal setor terbaru
    $setorQuery = Setor::join('users', 'users.id', '=', 'setor.users_id')
        ->select('setor.*', 'users.name as nama')
        ->orderByDesc('setor.tgl_setor'); // Urutkan berdasarkan tanggal setor terbaru

    // Jika ada pencarian nama
    if ($nama) {
        $setorQuery->where('users.name', 'like', '%' . $nama . '%');
    }

    // Lakukan paginasi dengan jumlah data per halaman
    $setor = $setorQuery->paginate(10);

    // Jika tidak ada data setoran
    if ($setor->isEmpty()) {
        return view('admin.setor.index', compact('setor', 'users'))
            ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
    }

    return view('admin.setor.index', compact('setor', 'users'));
}


    public function create()
    {
        //
        return view('admin.setor.index', [
            'users' => DB::table('users')->where('jabatan', 'anggota')->orWhere('jabatan', 'petugas')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|exists:users,id', // pastikan name adalah id dari users
            'nominal' => 'required|numeric|min:50000',
            'jenis_setor' => 'required|max:20',
            'tgl_setor' => 'required|date',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.exists' => 'Nama tidak ditemukan dalam daftar pengguna',
            'nominal.required' => 'Nominal wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal adalah Rp. 50.000',
            'jenis_setor.required' => 'Jenis Setor wajib diisi',
            'tgl_setor.required' => 'Tanggal Setor wajib diisi',
            'tgl_setor.date' => 'Tanggal Setor harus berupa tanggal yang valid',
            'bukti_foto.max' => 'Foto maksimal 2 MB',
            'bukti_foto.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('storage/fotos_bukti/'), $fileName);
        } else {
            $fileName = null;
        }

        $userId = $request->name; 
        $totalNominal = $request->nominal;

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

        return redirect('admin/setor')->with('success', 'Berhasil Menambahkan Setoran');
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



    public function indexkonfirmasi()
    {
        $setorans = Setor::where('konfirmasi', Setor::STATUS_PENDING)->get();
        return view('admin.setor.konfirmasi', compact('setorans'));
    }

    public function konfirmasi($id)
{
    $setoran = Setor::find($id);
    if ($setoran) {
        $setoran->konfirmasi = Setor::STATUS_APPROVED;
        $setoran->save();

        if ($setoran->jenis_setor == 'Cicilan') {
            $this->prosesCicilan($setoran->users_id, $setoran->nominal);
        } else {
            $tabungan = Tabungan::where('users_id', $setoran->users_id)->first();
            if ($tabungan) {
                $tabungan->saldo += $setoran->nominal;
                $tabungan->save();
            } else {
                Tabungan::create([
                    'users_id' => $setoran->users_id,
                    'saldo' => $setoran->nominal,
                ]);
                Log::info("Tabungan baru dibuat untuk user_id: ", ['user_id' => $setoran->users_id]);
            }
        }
    }

    return redirect('/admin/konfirmasi')->with('success', 'Setoran Berhasil Dikonfirmasi');
}


public function tolak($id)
{
    $setoran = Setor::find($id);
    if ($setoran) {
        Log::info("Setoran ditemukan untuk ditolak: ", ['setoran' => $setoran]);
        $setoran->konfirmasi = Setor::STATUS_REJECTED;
        $setoran->save();

        // $tabungan = Tabungan::where('users_id', $setoran->users_id)->first();
        // if ($tabungan) {
        //     $tabungan->saldo -= $setoran->nominal;
        //     $tabungan->save();
        // }
    }

    return redirect('/admin/konfirmasi')->with('success', 'Setoran Berhasil Ditolak');
}


    public function riwayat()
    {
        $setorans = Setor::all();
        return view('admin.setor.riwayat', compact('setorans'));
    }
}
