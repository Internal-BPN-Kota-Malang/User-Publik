<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminFormulirController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Halaman Publik (Kantor Pertanahan)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/pengajuan', function () {
    return view('pengajuan');
})->name('pengajuan');

Route::get('/pengajuan/ajukan', [App\Http\Controllers\PengajuanFormController::class, 'create'])->name('pengajuan.create');
Route::post('/pengajuan/ajukan', [App\Http\Controllers\PengajuanFormController::class, 'store'])->name('pengajuan.store');

Route::get('/surat-kuasa', function () {
    return view('surat-kuasa');
})->name('surat-kuasa');

Route::get('/surat-kuasa/ajukan', function () {
    return view('surat-kuasa-ajukan');
})->name('surat-kuasa.ajukan');

Route::get('/surat-pernyataan', function () {
    return view('surat-pernyataan');
})->name('surat-pernyataan');

Route::get('/formulir-permohonan', function () {
    return view('formulir-permohonan');
})->name('formulir-permohonan');

Route::get('/formulir-ptsl', function () {
    return view('formulir-ptsl');
})->name('formulir-ptsl');

Route::get('/informasi', function () {
    return view('informasi');
})->name('informasi');

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');

/*
|--------------------------------------------------------------------------
| Rute Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth', 'admin.only'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    Route::get('/admin/pengajuan', [AdminController::class, 'pengajuanIndex'])->name('admin.pengajuan.index');
    Route::get('/admin/pengajuan/tambah', [AdminController::class, 'createPengajuan'])->name('admin.pengajuan.create');
    Route::post('/admin/pengajuan', [AdminController::class, 'storePengajuan'])->name('admin.pengajuan.store');
    Route::get('/admin/pengajuan/{pengajuan}', [AdminController::class, 'show'])->name('admin.pengajuan.show');
    Route::patch('/admin/pengajuan/{pengajuan}/status', [AdminController::class, 'updateStatus'])->name('admin.pengajuan.updateStatus');
    Route::delete('/admin/pengajuan/{pengajuan}', [AdminController::class, 'destroyPengajuan'])->name('admin.pengajuan.destroy');
    Route::get('/admin/formulir', [AdminFormulirController::class, 'index'])->name('admin.formulir');
    Route::get('/admin/formulir/tambah', [AdminFormulirController::class, 'create'])->name('admin.formulir.create');
    Route::post('/admin/formulir', [AdminFormulirController::class, 'store'])->name('admin.formulir.store');
    Route::get('/admin/formulir/{formulir}/edit', [AdminFormulirController::class, 'edit'])->name('admin.formulir.edit');
    Route::put('/admin/formulir/{formulir}', [AdminFormulirController::class, 'update'])->name('admin.formulir.update');
    Route::delete('/admin/formulir/{formulir}', [AdminFormulirController::class, 'destroy'])->name('admin.formulir.destroy');
    Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
});

/*
|--------------------------------------------------------------------------
| Rute Bawaan Breeze (jangan dihapus)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';