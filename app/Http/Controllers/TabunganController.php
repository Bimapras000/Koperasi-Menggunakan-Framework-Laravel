<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\User;
use App\Models\Tabungan;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    //

    public function index()
{
    $setor = DB::table('setor')->get();
    $users = DB::table('users')->get();
    $tabungan = Tabungan::join('users', 'users.id', '=', 'tabungan.users_id')
        ->select('tabungan.*', 'users.name as nama')
        ->get();
    return view('admin.tabungan.index', compact( 'users', 'tabungan'));
}


    public function create()
    {
        //
        return view('admin.tabungan.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'saldo' => 'required|numeric',
        ], [
            'users_id.required' => 'Nama wajib diisi',
            'users_id.exists' => 'User tidak ditemukan',
            'saldo.required' => 'Saldo wajib diisi',
            'saldo.numeric' => 'Saldo harus berupa angka',
            
        ]);

        DB::table('tabungan')->insert([
            'users_id' => $request->users_id,
            'saldo' => $request->saldo,
            
        ]);


        return redirect('admin/tabungan')->with('success', 'Berhasil Menambahkan Tabungan');
    }

    public function tarikSaldo(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $tabungan = Tabungan::findOrFail($id);

        // Pastikan saldo yang ingin ditarik tidak lebih besar dari saldo saat ini
        if ($request->amount > $tabungan->saldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        // Kurangi saldo
        $tabungan->saldo -= $request->amount;
        $tabungan->save();

        return redirect()->back()->with('success', 'Berhasil menarik saldo.');
    }
}
