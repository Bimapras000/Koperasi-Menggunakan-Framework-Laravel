<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EksportController;

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
    return view('auth.login');
});



// Custum Authenticate 
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['jabatan:anggota'])->group(function () {
    // Route::resource('user', UserController::class);
    Route::get('/user/dashboarduser',[UserController::class, 'index']);
    Route::get('/user/tabunganuser', [UserController::class, 'tabunganIndex'])->name('anggota.tabungan');
    Route::get('/user/setoruser', [UserController::class, 'setorIndex'])->name('anggota.setor');
    Route::post('/user/setoruser/store', [UserController::class, 'store'])->name('anggota.setor.store');
    Route::get('/user/invoice/{id}', [UserController::class, 'showInvoice'])->name('setor.invoice');
    Route::get('/user/invoice/download/{id}', [UserController::class, 'downloadInvoicePDF'])->name('setor.invoice.download');
    Route::get('/user/peminjaman', [UserController::class, 'pinjamanindex'])->name('anggota.peminjaman');
    Route::get('/user/peminjaman/{id}', [UserController::class, 'show'])->name('anggota.peminjaman.show');
    Route::get('/user/peminjaman/create', [UserController::class, 'create1'])->name('anggota.peminjaman.create');
    Route::post('/user/peminjaman/store', [UserController::class, 'store1'])->name('anggota.peminjaman.store');
    Route::get('/user/riwayatpeminjaman', [UserController::class, 'riwayat']);
    Route::get('/user/riwayat-tabungan', [UserController::class, 'riwayatTabungan'])->name('anggota.riwayat.tabungan');



});

Route::group(['middleware' => ['auth', 'jabatan:admin-petugas']], function(){
Route::prefix('admin')->group(function(){

// Route::get('/dashboard',[AdminController::class, 'index']);
Route::get('/dashboard',[DashboardController::class, 'index']);

//tabel anggota
Route::get('/anggota',[AnggotaController::class, 'index']);
Route::get('/anggota/create',[AnggotaController::class, 'create']);
Route::post('/anggota/store', [AnggotaController::class, 'store']);
Route::get('/anggota/{id}', [AnggotaController::class, 'show']);
Route::get('/anggota/edit/{id}',[AnggotaController::class, 'edit']);
Route::post('/anggota/update/{id}',[AnggotaController::class, 'update']);
Route::get('/anggota/delete/{id}',[AnggotaController::class, 'destroy']);
Route::get('/admin/anggota/anggotaPDF', [AnggotaController::class, 'anggotaPDF'])->name('anggota.pdf');
Route::get('/export-anggotaexcel', [AnggotaController::class, 'exportAnggotaExcel'])->name('anggota.excel');


//tabel petugas
Route::get('/petugas',[PetugasController::class, 'index']);
Route::get('/petugas/create',[PetugasController::class, 'create']);
Route::post('/petugas/store',[PetugasController::class, 'store']);
Route::get('/petugas/show/{id}',[PetugasController::class, 'show']);
Route::get('/petugas/edit/{id}',[PetugasController::class, 'edit']);
Route::post('/petugas/update/{id}',[PetugasController::class, 'update']);
Route::get('/petugas/delete/{id}',[PetugasController::class, 'destroy']);
Route::get('/petugas/petugasPDF', [PetugasController::class, 'petugasPDF'])->name('petugas.pdf');
Route::get('/export-petugasexcel', [PetugasController::class, 'exportPetugasExcel'])->name('petugas.excel');


//route setor
Route::get('/setor',[SetorController::class, 'index']);
Route::get('/setor/create',[SetorController::class, 'create'])->name('setor.create');
Route::post('/setor/store',[SetorController::class, 'store'])->name('setor.store');
Route::get('/setor/setorPDF', [SetorController::class, 'setorPDF'])->name('setor.pdf');
Route::get('/konfirmasi', [SetorController::class, 'indexkonfirmasi']);
Route::post('/konfirmasi/{id}', [SetorController::class, 'konfirmasi'])->name('setor.konfirmasi');
Route::post('/tolak/{id}', [SetorController::class, 'tolak'])->name('setor.tolak');
Route::get('/export-setorexcel', [SetorController::class, 'exportSetorExcel'])->name('Setor.excel');
Route::get('/admin/riwayat', [SetorController::class, 'riwayat']);


//route tabungan
Route::get('/tabungan',[TabunganController::class, 'index'])->name('tabungan.index');
Route::get('/tabungan/create',[TabunganController::class, 'create']);
Route::post('/tabungan/store',[TabunganController::class, 'store']);
Route::get('tabungan/edit/{id}', [TabunganController::class, 'edit'])->name('tabungan.edit');
Route::post('tabungan/update/{id}', [TabunganController::class, 'update'])->name('tabungan.update');
Route::post('tabungan/toggle-tarik/{id}', [TabunganController::class, 'toggleTarik'])->name('tabungan.toggle-tarik');
Route::get('/tabungan/delete/{id}',[TabunganController::class, 'destroy']);
Route::post('admin/tabungan/tarik/{id}', [TabunganController::class, 'tarikSaldo']);
Route::get('/tabungan-pdf', [TabunganController::class, 'tabunganPDF'])->name('tabungan.pdf');
Route::get('/export-excel', [TabunganController::class, 'exportExcel'])->name('tabungan.excel');


//route peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create']);
Route::post('/peminjaman/store', [PeminjamanController::class, 'store']);
Route::get('/riwayat', [PeminjamanController::class, 'riwayat']);
Route::get('/konfirmasi1', [PeminjamanController::class, 'konfirmasiIndex'])->name('pinjaman.konfirmasiIndex');
Route::post('/konfirmasi1/{id}', [PeminjamanController::class, 'konfirmasi'])->name('pinjaman.konfirmasi');
Route::get('/tolak/{id}/alasan', [PeminjamanController::class, 'alasanForm'])->name('pinjaman.tolak.alasan');
Route::post('/tolak/{id}/process', [PeminjamanController::class, 'processTolak'])->name('pinjaman.tolak.process');
Route::get('/peminjaman-pdf', [PeminjamanController::class, 'peminjamanPDF'])->name('Peminjaman.pdf');
Route::get('/export-peminjamanexcel', [PeminjamanController::class, 'exportpeminjamanExcel'])->name('Peminjaman.excel');

//route eksport
Route::get('/EksportPDF', [EksportController::class, 'index'])->name('index.pdf');
Route::get('/export-pdf', [EksportController::class, 'exportPDF'])->name('export.pdf');



});
});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
