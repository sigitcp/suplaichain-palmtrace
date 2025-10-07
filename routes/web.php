<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\KebunPetaniController;
use App\Http\Controllers\ProfilPengepulController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('petani.transaksi.index');
});


// hanya bisa diakses ADMIN (role_id = 1)
Route::middleware(['role:admin'])->group(function () {
    // USER (sudah ada di kamu)
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


    Route::get('/transaksi', function () {
        return view('petani.transaksi.index');
    });
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
