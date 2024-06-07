<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



// Custum Authenticate 
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'jabatan:admin-petugas']], function(){
Route::prefix('admin')->group(function(){

Route::get('/dashboard',[AdminController::class, 'index']);

//tabel anggota
Route::get('/anggota',[AnggotaController::class, 'index']);
Route::get('/anggota/create',[AnggotaController::class, 'create']);
Route::post('/anggota/store', [AnggotaController::class, 'store']);
Route::get('/anggota/{id}', [AnggotaController::class, 'show']);
Route::get('/anggota/edit/{id}',[AnggotaController::class, 'edit']);
Route::post('/anggota/update/{id}',[AnggotaController::class, 'update']);
Route::get('/anggota/delete/{id}',[AnggotaController::class, 'destroy']);

//tabel petugas
Route::get('/petugas',[PetugasController::class, 'index']);
Route::get('/petugas/create',[PetugasController::class, 'create']);
Route::post('/petugas/store',[PetugasController::class, 'store']);
Route::get('/petugas/show/{id}',[PetugasController::class, 'show']);
Route::get('/petugas/edit/{id}',[PetugasController::class, 'edit']);
Route::post('/petugas/update/{id}',[PetugasController::class, 'update']);
Route::get('/petugas/delete/{id}',[PetugasController::class, 'destroy']);


//route setor
Route::get('/setor',[SetorController::class, 'index']);
Route::get('/setor/create',[SetorController::class, 'create'])->name('setor.create');
Route::post('/setor/store',[SetorController::class, 'store'])->name('setor.store');

Route::get('/konfirmasi', [SetorController::class, 'indexkonfirmasi']);
Route::post('/konfirmasi/{id}', [SetorController::class, 'konfirmasi'])->name('setor.konfirmasi');
Route::post('/admin/tolak/{id}', [SetorController::class, 'tolak'])->name('setor.tolak');

Route::get('/admin/riwayat', [SetorController::class, 'riwayat']);


//route tabungan
Route::get('/tabungan',[TabunganController::class, 'index']);
Route::get('/tabungan/create',[TabunganController::class, 'create']);
Route::post('/tabungan/store',[TabunganController::class, 'store']);
Route::post('admin/tabungan/tarik/{id}', [TabunganController::class, 'tarikSaldo']);

//route peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);
Route::post('/peminjaman', [PeminjamanController::class, 'store']);

});
});
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
