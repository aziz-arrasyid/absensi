<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\dashboardAdminController;
use App\Http\Controllers\dashboardPegawaiController;
use App\Http\Controllers\SeksiController;

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

Route::get('/login', [loginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/authenticate', [loginController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth', 'user-role:admin'])->prefix('dashboard-admin')->group(function () {
    Route::get('/', [dashboardAdminController::class, 'index'])->name('admin');
    Route::get('/rekap', [dashboardAdminController::class, 'rekap'])->name('rekap');
    Route::get('/pdf', [dashboardAdminController::class, 'pdf'])->name('pdf');
    Route::get('/filterData', [dashboardAdminController::class, 'filterData'])->name('filterData');
    Route::get('/OnePDF/{tanggal}', [dashboardAdminController::class, 'generateOnePDF'])->name('OnePDF');
    Route::get('/OneMonthPDF/{tahun}/{bulan}', [dashboardAdminController::class, 'generateOneMonthPDF'])->name('OneMonthPDF');
    Route::get('/lihat-absen/{id}', [dashboardAdminController::class, 'show'])->name('show.absen');
    Route::resource('data-jabatan', JabatanController::class);
    Route::resource('data-bidang', BidangController::class);
    Route::resource('data-seksi', SeksiController::class);
    Route::resource('data-pegawai', PegawaiController::class);
    Route::resource('data-absensi', AbsensiController::class);
    Route::resource('data-absen', AbsenController::class);
    Route::get('/logout', [logoutController::class, 'logout'])->name('logout');

});

Route::get('/logout', [logoutController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'user-role:pegawai'])->prefix('dashboard-pegawai')->group(function () {
    Route::get('/', [dashboardPegawaiController::class, 'index'])->name('pegawai');
    Route::resource('data-absen', AbsenController::class);
});
