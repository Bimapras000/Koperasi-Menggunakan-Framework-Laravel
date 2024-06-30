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

class UserController extends Controller
{
    //
    public function index()
    {
       
        $user = Auth::user();
        $jumlahPeminjaman = $user->peminjaman()->sum('nominal');
        $setoranMingguIni = $user->setor()->where('tgl_setor', '>=', now()->startOfWeek())->sum('nominal');
        $totalTabungan = $user->tabungan()->sum('saldo');
        $transaksiSetoranTerakhir = $user->setor()->orderBy('tgl_setor', 'desc')->take(10)->get();

        return view('user.dashboarduser', compact('jumlahPeminjaman', 'setoranMingguIni', 'totalTabungan', 'transaksiSetoranTerakhir'));
    }

    public function tabunganIndex()
    {
        $user = Auth::user();
        $tabungan = $user->tabungan; // Mengambil data tabungan yang terkait dengan user yang login

        return view('user.tabunganuser', compact('tabungan'));
    }

    public function setorIndex()
    {
        $userId = Auth::id();
        $setor = Setor::where('users_id', $userId)->paginate(10);

        return view('user.setoruser', compact('setor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:50000',
            'jlm_setor' => 'required|numeric',
            'tgl_setor' => 'required|date',
            'jenis_setor' => 'required|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setoran = new Setor();
        $setoran->user_id = Auth::id();
        $setoran->nominal = $request->nominal;
        $setoran->jlm_setor = $request->jlm_setor;
        $setoran->total_nominal = $request->nominal * $request->jlm_setor;
        $setoran->tgl_setor = $request->tgl_setor;
        $setoran->jenis_setor = $request->jenis_setor;

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $setoran->bukti_foto = $filename;
        }

        $setoran->save();

        return redirect()->route('user.setoruser')->with('success', 'Setoran berhasil ditambahkan.');
    }
}
