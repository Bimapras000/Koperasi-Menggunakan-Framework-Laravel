<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\User;
use App\Models\Tabungan;
use Illuminate\Support\Facades\DB;

class SetorController extends Controller
{
    //
    public function index()
    {
        //
        $users = User::all();
        $setoran = Setor::all();
        $setor = Setor::join('users', 'users.id', '=', 'setor.users_id')
        ->select('setor.*', 'users.name as nama')
        ->get();
        return view ('admin.setor.index', compact('setor','users','setoran'));
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
            'nominal' => 'required|numeric',
            'jlm_setor' => 'required|numeric',
            'jenis_setor' => 'required|max:20',
            'tgl_setor' => 'required|date',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.exists' => 'Nama tidak ditemukan dalam daftar pengguna',
            'nominal.required' => 'Nominal wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'jlm_setor.required' => 'Jumlah Setor wajib diisi',
            'jlm_setor.numeric' => 'Jumlah Setor harus berupa angka',
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

        // Insert ke tabel setor
        $setorId = DB::table('setor')->insertGetId([
            'users_id' => $userId,
            'nominal' => $request->nominal,
            'jlm_setor' => $request->jlm_setor,
            'jenis_setor' => $request->jenis_setor,
            'tgl_setor' => $request->tgl_setor,
            'bukti_foto' => $fileName,
            'konfirmasi' => Setor::STATUS_PENDING,
        ]);

        // Update saldo di tabel tabungan
        $tabungan = Tabungan::where('users_id', $userId)->first();
        if ($tabungan) {
            $tabungan->saldo += $request->nominal;
            $tabungan->save();
        } else {
            // Jika tidak ada tabungan, maka buat baru
            Tabungan::create([
                'users_id' => $userId,
                'saldo' => $request->nominal,
                'setor_id' => $setorId,
            ]);
        }

        return redirect('admin/setor')->with('success', 'Berhasil Menambahkan Setoran');
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

            $tabungan = Tabungan::where('users_id', $setoran->users_id)->first();
            if ($tabungan) {
                $tabungan->saldo += $setoran->nominal;
                $tabungan->save();
            } else {
                Tabungan::create([
                    'users_id' => $setoran->users_id,
                    'saldo' => $setoran->nominal,
                    'setor_id' => $setoran->id,
                ]);
            }
        }

        return redirect('/admin/konfirmasi')->with('success', 'Setoran Berhasil Dikonfirmasi');
    }

    public function tolak($id)
    {
        $setoran = Setor::find($id);
        if ($setoran) {
            $setoran->konfirmasi = Setor::STATUS_REJECTED;
            $setoran->save();
        }

        return redirect('/admin/konfirmasi')->with('success', 'Setoran Berhasil Ditolak');
    }

    public function riwayat()
    {
        $setorans = Setor::all();
        return view('admin.setor.riwayat', compact('setorans'));
    }
}
