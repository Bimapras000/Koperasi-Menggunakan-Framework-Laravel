<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Peminjaman;
use App\Models\Setor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        // Jumlah anggota
        $jumlahAnggota = User::count();

        // Jumlah peminjam
        $jumlahPeminjaman = Peminjaman::where('status', 'Belum Lunas')->sum('total');

        // Setoran minggu ini (khusus menabung)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $setoranMingguIni = Setor::where('jenis_setor', 'Menabung')
            ->whereBetween('tgl_setor', [$startOfWeek, $endOfWeek])
            ->sum('nominal');

        // Total tabungan
        $totalTabungan = Tabungan::sum('saldo');

        // Transaksi setoran terakhir
        $transaksiSetoranTerakhir = Setor::join('users', 'setor.users_id', '=', 'users.id')
            ->select('setor.*', 'users.name as user_name')
            ->orderBy('setor.tgl_setor', 'desc')
            ->limit(10)
            ->get();

        // Ambil data konfirmasi setoran yang belum dikonfirmasi
        $setoranBelumDikonfirmasi = Setor::where('konfirmasi', Setor::STATUS_PENDING)->get();

        // Ambil data konfirmasi pinjaman yang belum dikonfirmasi
        $pinjamanBelumDikonfirmasi = Peminjaman::where('konfirmasi', Peminjaman::STATUS_PENDING)->get();

            return view('admin.dashboard', compact('setoranBelumDikonfirmasi', 'pinjamanBelumDikonfirmasi','jumlahAnggota', 'jumlahPeminjaman', 'setoranMingguIni', 'totalTabungan', 'transaksiSetoranTerakhir'));
        }
    
}
