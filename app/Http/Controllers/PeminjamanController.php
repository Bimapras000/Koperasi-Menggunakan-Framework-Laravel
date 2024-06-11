<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::all();
        $nama = $request->input('name');
        
        if ($nama) {
            $peminjaman = Peminjaman::whereHas('user', function ($query) use ($nama) {
                $query->where('name', 'like', '%'.$nama.'%');
            })->paginate(4);
        } else {
            $peminjaman = Peminjaman::paginate(4);
        }

        return view('admin.peminjaman.index', compact('peminjaman', 'users'));
    }

    public function create()
    {
        $users = User::where('jabatan', 'anggota')->orWhere('jabatan', 'petugas')->get();
        return view('admin.peminjaman.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'no_tlp' => 'required',
            'keperluan' => 'required',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date|after_or_equal:tgl_peminjaman',
            'bunga' => 'required|numeric',
            'users_id' => 'required|exists:users,id'
        ]);

        Peminjaman::create([
            'users_id' => $request->users_id,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'keperluan' => $request->keperluan,
            'tgl_peminjaman' => $request->tgl_peminjaman,
            'tgl_pengembalian' => $request->tgl_pengembalian,
            'bunga' => $request->bunga,
            'konfirmasi' => 0,

        ]);

        return redirect('admin/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan');
    }
}
