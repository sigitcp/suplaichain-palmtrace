<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LahanController;
use App\Http\Controllers\ProfilPengepulController;
use App\Http\Controllers\ProfilPetaniController;
use App\Http\Controllers\ProfilPksController;
use App\Http\Controllers\ProfilRefineryController;
use App\Http\Controllers\HargaTbsMingguanController;
use App\Http\Controllers\HargaCpoMingguanController;
use App\Http\Controllers\ArtikelController;

use App\Http\Controllers\DashboardPetaniController;
use App\Http\Controllers\PengepulPenawaranTbsController;
use App\Http\Controllers\PetaniPenawaranTbsController;

use App\Http\Controllers\PenimbanganPengepulController;
use App\Http\Controllers\PenjualanTbsPetaniController;

use App\Http\Controllers\PengepulPenerimaanTbsController;

use App\Http\Controllers\PksPenerimaanTbsController;
use App\Http\Controllers\PengepulPenawaranPksController;
use App\Http\Controllers\PksPenimbanganTbsController;

use App\Http\Controllers\RiwayatTransaksiPetaniController;
use App\Http\Controllers\PetaPksPengepulController;
use App\Http\Controllers\KebunPetaniController;
use App\Http\Controllers\DetailProfilPetaniController;
use App\Http\Controllers\ArtikelPetaniController;
use App\Http\Controllers\DashboardPengepulController;
use App\Http\Controllers\RiwayatTransaksiPengepulController;
use App\Http\Controllers\DashboardPksController;
use App\Http\Controllers\RiwayatTransaksiPksController;
use App\Http\Controllers\PksCpoOfferController;
use App\Http\Controllers\PetaPksController;
use App\Http\Controllers\PenawaranCpoRefineryController;
use Illuminate\Support\Facades\Route;


// hanya bisa diakses ADMIN (role_id = 1)
Route::middleware(['role:admin'])->group(function () {
    // USER 
    Route::get('/dashboardadmin', [DashboardAdminController::class, 'index'])->name('admin.dashboard.index');
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

    Route::get('profilpengepul', [ProfilPengepulController::class, 'index'])->name('daftar-pengepul');
    Route::get('profilpengepul/{id}/profil', [ProfilPengepulController::class, 'kelolaProfil'])->name('kelola-profil-pengepul');
    Route::post('profilpengepul/{id}/profil', [ProfilPengepulController::class, 'storeOrUpdate'])->name('simpan-profil-pengepul');


    Route::get('profilpetani', [ProfilPetaniController::class, 'index'])->name('daftar-profil-petani');
    Route::get('profilpetani/{id}', [ProfilPetaniController::class, 'kelola'])->name('kelola-profil-petani');
    Route::post('profilpetani/{id}', [ProfilPetaniController::class, 'storeOrUpdate'])->name('simpan-profil-petani');

    Route::get('profilpks', [ProfilPksController::class, 'index'])->name('daftar-pks');
    Route::get('profilpks/{id}', [ProfilPksController::class, 'kelola'])->name('kelola-profil-pks');
    Route::post('profilpks/{id}', [ProfilPksController::class, 'storeOrUpdate'])->name('simpan-profil-pks');

    Route::get('/profilrefinery', [ProfilRefineryController::class, 'index'])->name('refinery.index');
    Route::get('/profilrefinery/{id}', [ProfilRefineryController::class, 'kelola'])->name('kelola-profil-refinery');
    Route::post('/profilrefinery/{id}', [ProfilRefineryController::class, 'storeOrUpdate'])->name('store-profil-refinery');

    Route::get('/hargatbs', [HargaTbsMingguanController::class, 'index'])->name('harga-tbs.index');
    Route::post('/hargatbs/store', [HargaTbsMingguanController::class, 'store'])->name('harga-tbs.store');
    Route::post('/hargatbs/update/{id}', [HargaTbsMingguanController::class, 'update'])->name('harga-tbs.update');
    Route::delete('/hargatbs/delete/{id}', [HargaTbsMingguanController::class, 'destroy'])->name('harga-tbs.delete');

    Route::get('/hargacpo', [HargaCpoMingguanController::class, 'index'])->name('harga-cpo.index');
    Route::post('/hargacpo', [HargaCpoMingguanController::class, 'store'])->name('harga-cpo.store');
    Route::post('/hargacpo/{id}', [HargaCpoMingguanController::class, 'update'])->name('harga-cpo.update');
    Route::delete('/hargacpo/{id}', [HargaCpoMingguanController::class, 'destroy'])->name('harga-cpo.destroy');



    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::get('/artikel/{id}/detail', [ArtikelController::class, 'show'])->name('artikel.show');
});

Route::middleware(['auth', 'role:petani'])->group(function () {
    Route::get('/dashboardpetani', [DashboardPetaniController::class, 'index'])->name('petani.dashboard.index');
    Route::get('/petani/penawaran-tbs', [PetaniPenawaranTbsController::class, 'index'])->name('petani.penawaran.index');
    Route::post('/petani/penawaran-tbs', [PetaniPenawaranTbsController::class, 'store'])->name('petani.penawaran.store');
    Route::delete('/petani/penawaran-tbs/{id}', [PetaniPenawaranTbsController::class, 'destroy'])->name('petani.penawaran.destroy');

    Route::get('/monitoring/{id}', [KebunPetaniController::class, 'index'])->name('petani.monitoring.index');

    Route::get('petani/penerimaan-tbs', [PenjualanTbsPetaniController::class, 'index'])->name('petani.penerimaantbs.index');
    Route::post('petani/penerimaan-tbs', [PenjualanTbsPetaniController::class, 'store'])->name('petani.penerimaantbs.store');

    Route::get('/permintaan-tbs', [PenjualanTbsPetaniController::class, 'index'])->name('petani.permintaantbs.index');
    Route::post('/permintaan-tbs/store', [PenjualanTbsPetaniController::class, 'store'])->name('petani.permintaantbs.store');

    Route::get('/riwayat-transaksi', [RiwayatTransaksiPetaniController::class, 'index'])->name('petani.riwayattransaksi.index');

    Route::get('/peta', [PetaPksPengepulController::class, 'index'])->name('petani.peta.index');
    Route::get('/peta/{type}/{id}', [PetaPksPengepulController::class, 'show'])->name('petani.peta.detail');

    Route::get('/profil', [DetailProfilPetaniController::class, 'index'])->name('profil.index');

    Route::get('/artikelpetani', [ArtikelPetaniController::class, 'index'])->name('artikel.index.petani');
    Route::get('/artikelpetani/{id}', [ArtikelPetaniController::class, 'show'])->name('petani.artikel.detail');
});


Route::middleware(['auth', 'role:pengepul'])->group(function () {
    Route::get('/dashboardpengepul', [DashboardPengepulController::class, 'index'])->name('pengepul.dashboard.index');
    Route::get('/pengepul/penawaran-tbs', [PengepulPenawaranTbsController::class, 'index'])->name('pengepul.penawaran.index');
    Route::post('/pengepul/penawaran-tbs/{id}/reserve', [PengepulPenawaranTbsController::class, 'reserve'])->name('pengepul.penawaran.reserve');
    Route::post('/pengepul/penawaran-tbs/{id}/cancel', [PengepulPenawaranTbsController::class, 'cancel'])->name('pengepul.penawaran.cancel');

    Route::get('/pengepul/riwayat-transaksi', [RiwayatTransaksiPengepulController::class, 'index'])->name('pengepul.riwayattransaksi.index');

    // Penimbangan
    Route::get('penimbangan', [PenimbanganPengepulController::class, 'index'])->name('pengepul.penimbangan.index');
    Route::post('penimbangan/store', [PenimbanganPengepulController::class, 'store'])->name('pengepul.penimbangan.store');

    // Penerimaan TBS oleh Pengepul
    Route::get('penerimaantbs', [PengepulPenerimaanTbsController::class, 'index'])->name('pengepul.penerimaantbs.index');
    Route::post('penerimaantbs/store', [PengepulPenerimaanTbsController::class, 'store'])->name('pengepul.penerimaantbs.store');
    Route::post('penerimaantbs/toggle', [PengepulPenerimaanTbsController::class, 'toggle'])->name('pengepul.penerimaantbs.toggle');
    Route::put('penerimaantbs/konfirmasi/{id}', [PengepulPenerimaanTbsController::class, 'konfirmasi'])->name('pengepul.penerimaantbs.konfirmasi');


    Route::get('penawaran-pks', [PengepulPenawaranPksController::class, 'index'])->name('pengepul.penawaranpks.index');
    Route::post('penawaran-pks/store', [PengepulPenawaranPksController::class, 'store'])->name('pengepul.penawaranpks.store');
});

Route::middleware('pks')->middleware(['auth', 'role:pks'])->group(function () {
    Route::get('/pks/dashboard', [DashboardPksController::class, 'index'])->name('pks.dashboard.index');
    Route::get('penerimaan-tbs', [PksPenerimaanTbsController::class, 'index'])->name('pks.penerimaantbs.index');
    Route::post('penerimaan-tbs/store', [PksPenerimaanTbsController::class, 'store'])->name('pks.penerimaantbs.store');
    Route::post('penerimaan-tbs/toggle', [PksPenerimaanTbsController::class, 'toggle'])->name('pks.penerimaantbs.toggle');
    Route::put('penerimaan-tbs/konfirmasi/{id}', [PksPenerimaanTbsController::class, 'konfirmasi'])->name('pks.penerimaantbs.konfirmasi');

    Route::get('penimbangan-tbs', [PksPenimbanganTbsController::class, 'index'])->name('pks.penimbangantbs.index');
    Route::post('penimbangan-tbs/store', [PksPenimbanganTbsController::class, 'store'])->name('pks.penimbangantbs.store');

    Route::get('/pks/riwayat-transaksi', [RiwayatTransaksiPksController::class, 'index'])->name('pks.riwayattransaksi.index');

    Route::get('/pks/penawaran-cpo', [PksCpoOfferController::class, 'index'])->name('pks.cpooffer.index');
    Route::post('/pks/penawaran-cpo', [PksCpoOfferController::class, 'storeOrUpdate'])->name('pks.cpooffer.store');
    Route::post('/pks/penawaran-cpo/toggle', [PksCpoOfferController::class, 'toggleStatus'])->name('pks.cpooffer.toggle');
});

Route::middleware('refinery')->middleware(['auth', 'role:refinery'])->group(function () {

    Route::get('pks/detail/{id}', [PetaPksController::class, 'show'])->name('pks.detail');
    Route::get('pks/peta', [PetaPksController::class, 'index'])->name('refinery.peta.index');
    Route::get('/refinery/penawaran-cpo', [PenawaranCpoRefineryController::class, 'index'])->name('penawaran.index');


});


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
