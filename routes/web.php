<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\KebunPetaniController;
use App\Http\Controllers\ProfilPengepulController;
use App\Http\Controllers\TransaksiPetaniController;
use App\Http\Controllers\TransaksiPengepulController;
use App\Http\Controllers\PenimbanganPengepulController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pengepul.transaksi.index');
});


// hanya bisa diakses ADMIN (role_id = 1)
Route::middleware(['role:admin'])->group(function () {
    // USER 
    Route::resource('/users', UserController::class);
    // ================= LAHAN =================
    Route::get('/lahan', [LahanController::class, 'index'])->name('lahan.index');
    // tampilkan semua user role petani
    Route::get('/kelola-lahan/{userId}', [LahanController::class, 'kelolaLahan'])->name('kelola-lahan');
    Route::post('/kelola-lahan/{userId}/store', [LahanController::class, 'storeLahan'])->name('lahan.store');
    Route::put('/lahan/{id}/update', [LahanController::class, 'updateLahan'])->name('lahan.update');
    Route::delete('/lahan/{id}/delete', [LahanController::class, 'destroyLahan'])->name('lahan.destroy');

    // ================= DETAIL LAHAN =================
    Route::get('/kelola-detail-lahan/{lahanId}', [LahanController::class, 'kelolaDetailLahan'])->name('kelola-detail-lahan');
    Route::post('/detail-lahan/{lahanId}/simpan', [LahanController::class, 'simpanAtauUpdateDetailLahan'])->name('detail-lahan.simpan');


    Route::get('/pengepul', [ProfilPengepulController::class, 'index'])->name('profil-pengepul');
    Route::get('/pengepul/{id}', [ProfilPengepulController::class, 'kelolaProfil'])->name('kelola-profil-pengepul');
    Route::post('/pengepul/{id}', [ProfilPengepulController::class, 'storeOrUpdate'])->name('simpan-profil-pengepul');
});

Route::middleware(['auth', 'role:petani'])->group(function () {
    Route::get('/kebun/{id}', [KebunPetaniController::class, 'index'])->name('petani.monitoring.index');
    Route::post('/kebun/{id}/panen', [KebunPetaniController::class, 'storePanen'])->name('petani.monitoring.storePanen');
    Route::put('/kebun/{id}/panen/{panen}', [KebunPetaniController::class, 'updatePanen'])->name('petani.monitoring.updatePanen');
    Route::delete('/kebun/{id}/panen/{panen}', [KebunPetaniController::class, 'deletePanen'])->name('petani.monitoring.deletePanen');


    Route::get('/transaksipenjualan', [TransaksiPetaniController::class, 'index'])->name('petani.transaksi.index');
    Route::post('/transaksipenjualan', [TransaksiPetaniController::class, 'store'])->name('petani.transaksi.store');
});


Route::middleware(['auth', 'role:pengepul'])->group(function () {
    Route::get('/transaksipembelian', [TransaksiPengepulController::class, 'index'])->name('pengepul.transaksi.index');
    Route::post('/transaksipembelian/{id}/store', [TransaksiPengepulController::class, 'store'])->name('pengepul.transaksi.store');
    Route::get('/penimbangan', [PenimbanganPengepulController::class, 'index'])->name('pengepul.penimbangan.index');
    Route::put('/penimbangan/{id}', [PenimbanganPengepulController::class, 'update'])->name('pengepul.penimbangan.update');
    Route::get('/pemasok', [App\Http\Controllers\PemasokPengepulController::class, 'index'])->name('pengepul.pemasok');
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
