<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminAbsensiController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminSopController;
use App\Http\Controllers\AdministratorLoginController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PembimbingDashboardController;
use App\Http\Controllers\PembimbingAbsensiController;
use App\Http\Controllers\PembimbingLaporanController;
use App\Http\Controllers\PembimbingSopController;
use App\Http\Controllers\PklDashboardController;
use App\Http\Controllers\PklLaporanController;
use App\Http\Controllers\PklSopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanMachineController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scan', [ScanMachineController::class, 'index'])->name('scan.machine');
Route::get('/scan/snapshot', [ScanMachineController::class, 'snapshot'])->name('scan.snapshot');

Route::get('/administrator/login', [AdministratorLoginController::class, 'show'])->name('login');
Route::post('/administrator/login', [AdministratorLoginController::class, 'login']);
Route::post('/administrator/logout', [AdministratorLoginController::class, 'logout'])->name('administrator.logout');

Route::get('/login', [UserLoginController::class, 'show'])->name('user.login');
Route::post('/login', [UserLoginController::class, 'login']);
Route::post('/logout', [UserLoginController::class, 'logout'])->name('user.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [ProfileController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [ProfileController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password.update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('admin.users.reset-password');

    Route::get('/admin/pembimbing', [PembimbingController::class, 'index'])->name('admin.pembimbing.index');
    Route::get('/admin/pembimbing/{pembimbing}', [PembimbingController::class, 'show'])->name('admin.pembimbing.show');
    Route::post('/admin/pembimbing/{pembimbing}/assign', [PembimbingController::class, 'assign'])->name('admin.pembimbing.assign');
    Route::delete('/admin/pembimbing/{pembimbing}/unassign/{pkl}', [PembimbingController::class, 'unassign'])->name('admin.pembimbing.unassign');

    Route::get('/admin/absensi', [AdminAbsensiController::class, 'index'])->name('admin.absensi.index');
    Route::delete('/admin/absensi/{absensi}', [AdminAbsensiController::class, 'destroyAbsensi'])->name('admin.absensi.destroy');
    Route::post('/admin/absensi/{izinSakit}/approve', [AdminAbsensiController::class, 'approve'])->name('admin.absensi.approve');
    Route::post('/admin/absensi/{izinSakit}/reject', [AdminAbsensiController::class, 'reject'])->name('admin.absensi.reject');
    Route::delete('/admin/absensi/izin/{izinSakit}', [AdminAbsensiController::class, 'destroyIzinSakit'])->name('admin.absensi.izin.destroy');

    Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/{laporan}', [AdminLaporanController::class, 'show'])->name('admin.laporan.show');
    Route::post('/admin/laporan/{laporan}/validate', [AdminLaporanController::class, 'validate'])->name('admin.laporan.validate');
    Route::delete('/admin/laporan/{laporan}', [AdminLaporanController::class, 'destroy'])->name('admin.laporan.destroy');

    Route::get('/admin/sop', [AdminSopController::class, 'index'])->name('admin.sop.index');
    Route::get('/admin/sop/create', [AdminSopController::class, 'create'])->name('admin.sop.create');
    Route::post('/admin/sop', [AdminSopController::class, 'store'])->name('admin.sop.store');
    Route::get('/admin/sop/{sop}/edit', [AdminSopController::class, 'edit'])->name('admin.sop.edit');
    Route::put('/admin/sop/{sop}', [AdminSopController::class, 'update'])->name('admin.sop.update');
    Route::delete('/admin/sop/{sop}', [AdminSopController::class, 'destroy'])->name('admin.sop.destroy');
});

Route::middleware(['auth', 'pkl'])->group(function () {
    Route::get('/pkl', [PklDashboardController::class, 'index'])->name('pkl.dashboard');
    Route::get('/pkl/absensi', [AbsensiController::class, 'index'])->name('pkl.absensi');
    Route::post('/pkl/absensi/qr', [AbsensiController::class, 'generateQr'])->name('pkl.absensi.qr');
    Route::post('/pkl/absensi/izin', [AbsensiController::class, 'izinSakit'])->name('pkl.absensi.izin');
    Route::get('/pkl/absensi/check/{token}', [AbsensiController::class, 'check'])->name('pkl.absensi.check');

    Route::get('/pkl/laporan', [PklLaporanController::class, 'index'])->name('pkl.laporan');
    Route::post('/pkl/laporan', [PklLaporanController::class, 'store'])->name('pkl.laporan.store');

    Route::get('/pkl/sop', [PklSopController::class, 'index'])->name('pkl.sop.index');
    Route::get('/pkl/sop/{sop}', [PklSopController::class, 'show'])->name('pkl.sop.show');
});

Route::get('/pkl/absensi/scan/{token}', [AbsensiController::class, 'scan'])->name('pkl.absensi.scan');

Route::middleware(['auth', 'pembimbing'])->group(function () {
    Route::get('/pembimbing', [PembimbingDashboardController::class, 'index'])->name('pembimbing.dashboard');
    Route::get('/pembimbing/absensi', [PembimbingAbsensiController::class, 'index'])->name('pembimbing.absensi.index');
    Route::get('/pembimbing/laporan', [PembimbingLaporanController::class, 'index'])->name('pembimbing.laporan.index');
    Route::get('/pembimbing/laporan/{laporan}', [PembimbingLaporanController::class, 'show'])->name('pembimbing.laporan.show');

    Route::get('/pembimbing/sop', [PembimbingSopController::class, 'index'])->name('pembimbing.sop.index');
    Route::get('/pembimbing/sop/{sop}', [PembimbingSopController::class, 'show'])->name('pembimbing.sop.show');
});
