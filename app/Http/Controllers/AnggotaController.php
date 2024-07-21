<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tabungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AnggotaController extends Controller
{
    //
    public function index(Request $request)
    {
       
        $users = User::all();


        $nama = $request->input('name'); // Mengambil nilai dari input 'name'
    
    // if ($nama) {
    //     $users = User::where('name', 'like', '%'.$nama.'%')->paginate(2);
    //     if ($users->isEmpty()) {
    //         return view('admin.anggota.index', compact('users'))
    //             ->withErrors('Tidak ada data yang sesuai dengan pencarian.');
    //     }
    // } else {
    //     $users = User::paginate(2);
    // }
    $users = User::where('jabatan', 'anggota')
        ->when($nama, function ($query, $nama) {
            return $query->where('name', 'like', '%' . $nama . '%');
        })
        ->paginate(10);

        return view ('admin.anggota.index', compact('users'));
    }

    public function create()
    {
        //
        return view('admin.anggota.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:45',
            'alamat' => 'required|max:45',
            'no_tlp' => 'required|max:13',
            'username' => 'required|unique:users|max:20',
            'password' => 'required|min:8',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            
        ],
        [
            'name.max' => 'Nama maximal 45 karakter',
            'name.required' => 'Nama wabjib diisi',
            
            'foto.max' => 'Maksimal 2 MB',
            'foto.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',

            'alamat.required' => 'Alamat wajib diisi',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'no_tlp.required' => 'Nomor Telepon wajib diisi',
            'no_tlp.max' => 'Nomor Telepon maksimal 13 karakter',
            
            'username.required' => 'username wajib diisi',
            'username.max' => 'username maksimal 20 karakter',
            'username.unique' => 'username sudah digunakan Anggota lain',

            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',

            'ktp.max' => 'KTP maksimal 2 MB',
            'ktp.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',
            // 'foto.required' => 'Foto harus diisi',
            
        ]);

        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = $file->getClientOriginalName(); // Memberikan nama unik untuk file
            $file->move(public_path('storage/fotos/'), $fileName); 
        } else {
            $fileName = null; // Atau beri nilai default jika tidak ada file yang diunggah
        }

       $userId = DB::table('users')->insertGetId([
        'ktp' => $fileName,
        'name' => $request->name,
        'alamat' => $request->alamat,
        'no_tlp' => $request->no_tlp,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'ktp' => $fileName,
        'jabatan' => $request->jabatan = 'anggota',
        
        ]);


        return redirect('admin/anggota')->with('success', 'Berhasil Menambahkan Anggota');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    //     $user = User::find($id);

    //     if (!$user) {
    //         return redirect('admin/anggota')->with('error', 'Anggota tidak ditemukan');
    //     }
    
    //     return view('admin.anggota.show', compact('user'));
    // }
    public function show($id)
{
    $user = User::find($id);
    return response()->json($user);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::all()->where('id', $id);
        $jabatans = User::distinct('jabatan')->pluck('jabatan');
        return view('admin.anggota.edit', compact('user','jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:45',
            'alamat' => 'required|max:45',
            'no_tlp' => 'required|max:13',
            'username' => 'required|max:20',
            'password' => 'required|min:8',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            
        ],
        [
            'name.max' => 'Nama maximal 45 karakter',
            'name.required' => 'Nama wabjib diisi',
            
            'foto.max' => 'Maksimal 2 MB',
            'foto.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',

            'alamat.required' => 'Alamat wajib diisi',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'no_tlp.required' => 'Nomor Telepon wajib diisi',
            'no_tlp.max' => 'Nomor Telepon maksimal 13 karakter',
            
            'username.required' => 'username wajib diisi',
            'username.max' => 'username maksimal 20 karakter',
            

            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',

            'ktp.max' => 'KTP maksimal 2 MB',
            'ktp.image' => 'File ekstensi harus jpg,jpeg,gif,svg,png,webp',
            // 'foto.required' => 'Foto harus diisi',
            
        ]);

        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = $file->getClientOriginalName(); // Memberikan nama unik untuk file
            $file->move(public_path('storage/fotos/'), $fileName); 
        } else {
            $fileName = null; // Atau beri nilai default jika tidak ada file yang diunggah
        }

        DB::table('users')->where('id', $request->id)->update([
            'ktp' => $fileName,
            'name' => $request->name,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'ktp' => $fileName,
            'jabatan' => $request->jabatan ,
        

        
        ]);
        return redirect('admin/anggota')->with('success', 'Berhasil Mengedit Anggota!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table('users')->where('id',$id)->delete();
        return redirect('admin/anggota')->with('success', 'Anggota Berhasil Dihapus!');
    }

    public function anggotaPDF(){
        // $anggota = User::get();
        // if ($anggota->isEmpty()) {
        //     return 'No data found';
        // }
        // $pdf = PDF::loadView('admin.anggota.anggotaPDF', ['anggota' => $anggota])->setPaper('a4', 'landscape');
        // return $pdf->stream();
        $anggota = User::where('jabatan', 'anggota')->get(); // Mengambil hanya pengguna dengan role 'anggota'
        $pdf = PDF::loadView('admin.anggota.anggotaPDF', ['anggota' => $anggota])->setPaper('a4', 'landscape');
        return $pdf->stream('anggota.pdf');
    }

    public function exportAnggotaExcel()
    {
        return Excel::download(new AnggotaExport, 'anggota.xlsx');
    }
}
