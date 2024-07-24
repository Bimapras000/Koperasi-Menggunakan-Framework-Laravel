<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setor;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TabunganExport;
use PDF;

class TabunganController extends Controller
{
    //

    public function index(Request $request)
{
    $search = $request->input('search');

    $setor = DB::table('setor')->get();
    $users = DB::table('users')->get();
    $tabunganQuery = Tabungan::join('users', 'users.id', '=', 'tabungan.users_id')
        ->select('tabungan.*', 'users.name as nama');

    if ($search) {
        $tabunganQuery->where('users.name', 'like', '%' . $search . '%')
                      ->orWhere('tabungan.saldo', 'like', '%' . $search . '%');
    }

    $tabungan = $tabunganQuery->paginate(10); // Adjust the number of items per page as needed

    return view('admin.tabungan.index', compact('users', 'tabungan', 'search'));
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
            'saldo' => 'required',
        ], [
            'users_id.required' => 'Nama wajib diisi',
            'users_id.exists' => 'User tidak ditemukan',
            'saldo.required' => 'Saldo wajib diisi',
            'saldo.numeric' => 'Saldo harus berupa angka',
            
        ]);

        $saldo = str_replace(['.', ','], '', $request->saldo);

        $tabungan = DB::table('tabungan')->where('users_id', $request->users_id)->first();
    
        if ($tabungan) {
            // Update saldo existing
            DB::table('tabungan')
                ->where('users_id', $request->users_id)
                ->update(['saldo' => $tabungan->saldo + $saldo]);
        } else {
            // Insert new tabungan
            DB::table('tabungan')->insert([
                'users_id' => $request->users_id,
                'saldo' => $saldo,
            ]);
        }


        return redirect('admin/tabungan')->with('success', 'Berhasil Menambahkan Tabungan');
    }

    public function edit($id)
{
    $tabungan = Tabungan::findOrFail($id);
    return view('admin.tabungan.edit', compact('tabungan'));
}

public function update(Request $request, $id)
{
    $tabungan = Tabungan::findOrFail($id);
    $tabungan->update($request->all());
    return redirect()->route('tabungan.index')->with('success', 'Data tabungan berhasil diedit.');
}

public function toggleTarik(Request $request)
{
    $tabungan = Tabungan::findOrFail($request->id);
    $tabungan->tarik_enabled = !$tabungan->tarik_enabled;
    $tabungan->save();

    return response()->json(['success' => 'Status tarik berhasil diubah.']);
}


    // public function tarikSaldo(Request $request, $id)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     $tabungan = Tabungan::findOrFail($id);

    //     // Pastikan saldo yang ingin ditarik tidak lebih besar dari saldo saat ini
    //     if ($request->amount > $tabungan->saldo) {
    //         return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
    //     }

    //     // Kurangi saldo
    //     $tabungan->saldo -= $request->amount;
    //     $tabungan->save();

    //     return redirect()->back()->with('success', 'Berhasil menarik saldo.');
    // }

    public function destroy(string $id)
    {
        //
        DB::table('tabungan')->where('id',$id)->delete();
        return redirect('admin/tabungan')->with('success', 'Tabungan Berhasil Dihapus!');
    }

    public function tabunganPDF(){
        // $anggota = User::get();
        // if ($anggota->isEmpty()) {
        //     return 'No data found';
        // }
        // $pdf = PDF::loadView('admin.anggota.anggotaPDF', ['anggota' => $anggota])->setPaper('a4', 'landscape');
        // return $pdf->stream();
        $tabungan = Tabungan::with('users')->whereHas('users', function($query) {
            $query->whereIn('jabatan', ['anggota', 'petugas']);
        })->get();

        $pdf = PDF::loadView('admin.tabungan.tabunganPDF', ['tabungan' => $tabungan])->setPaper('a4', 'landscape');
        
        return $pdf->stream('tabungan.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TabunganExport, 'tabungan.xlsx');
    }

    public function bayarCicilan(Request $request, $id) {
        $tabungan = Tabungan::find($id);
        if (!$tabungan) {
            return redirect()->back()->with('error', 'Data tabungan tidak ditemukan.');
        }
    
        $nominal = $request->input('nominal');
        $komentar = $request->input('komentar');
    
        // Cari peminjaman yang belum lunas
        $pinjaman = Peminjaman::where('users_id', $tabungan->users_id)
                            ->where('status', 'belum lunas')
                            ->first();
    
        if (!$pinjaman) {
            return redirect()->back()->with('error', 'Tidak ada pinjaman yang belum lunas.');
        }
    
        // Kurangi saldo tabungan
        $tabungan->saldo -= $nominal;
        $tabungan->save();
    
        // Kurangi nominal dari peminjaman
        $pinjaman->total -= $nominal;
        if ($pinjaman->total <= 0) {
            $pinjaman->status = 'lunas';
        }
        $pinjaman->save();
    
        // Simpan log atau histori pembayaran cicilan
        Peminjaman::create([
            'tabungan_id' => $tabungan->id,
            'pinjaman_id' => $pinjaman->id,
            'nominal' => $nominal,
            'komentar' => $komentar,
        ]);
    
        return redirect()->back()->with('success', 'Cicilan berhasil dibayar.');
    }
    
    
}
