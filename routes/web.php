<?php

use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\AdminController as AdminAdminController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\TahfidzController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Guru\GuruController as GuruGuruController;
use App\Http\Controllers\Guru\MemorizationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\SiswaController as SiswaSiswaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'guru':
            return redirect()->route('guru.dashboard');
        case 'siswa':
            return redirect()->route('siswa.dashboard');
        default:
            return redirect()->route('login'); // fallback
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminAdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Academic Management
    Route::get('/classes', [AcademicController::class, 'classes'])->name('classes.index');
    Route::get('/classes/create', [AcademicController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [AcademicController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}/edit', [AcademicController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [AcademicController::class, 'updateClass'])->name('classes.update');
    Route::delete('/classes/{class}', [AcademicController::class, 'destroyClass'])->name('classes.destroy');

    Route::get('/programs', [AcademicController::class, 'programs'])->name('programs.index');
    Route::get('/programs/create', [AcademicController::class, 'createProgram'])->name('programs.create');
    Route::post('/programs', [AcademicController::class, 'storeProgram'])->name('programs.store');
    Route::get('/programs/{program}', [AcademicController::class, 'showProgram'])->name('programs.show');
    Route::get('/programs/{program}/edit', [AcademicController::class, 'editProgram'])->name('programs.edit');
    Route::put('/programs/{program}', [AcademicController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/programs/{program}', [AcademicController::class, 'destroyProgram'])->name('programs.destroy');
    Route::post('/programs/{id}/restore', [AcademicController::class, 'restoreProgram'])->name('programs.restore');
    
    // Program Students Management
    Route::post('/programs/{program}/students', [AcademicController::class, 'addStudentToProgram'])->name('programs.students.store');
    Route::delete('/programs/{program}/students/{student}', [AcademicController::class, 'removeStudentFromProgram'])->name('programs.students.destroy');

    // Tahfidz Management
    Route::get('/target-programs', [TahfidzController::class, 'targetPrograms'])->name('target-programs.index');
    Route::get('/target-programs/create', [TahfidzController::class, 'createTargetProgram'])->name('target-programs.create');
    Route::post('/target-programs', [TahfidzController::class, 'storeTargetProgram'])->name('target-programs.store');
    Route::get('/target-programs/{targetProgram}/edit', [TahfidzController::class, 'editTargetProgram'])->name('target-programs.edit');
    Route::put('/target-programs/{targetProgram}', [TahfidzController::class, 'updateTargetProgram'])->name('target-programs.update');
    Route::delete('/target-programs/{targetProgram}', [TahfidzController::class, 'destroyTargetProgram'])->name('target-programs.destroy');

    Route::get('/rekap-hafalan', [TahfidzController::class, 'rekapHafalan'])->name('rekap-hafalan');
    Route::get('/rekap-hafalan/export', [TahfidzController::class, 'exportRekapHafalan'])->name('rekap-hafalan.export');

    Route::get('/settings', [AdminAdminController::class, 'settings'])->name('settings');

    // Memorizations Management
    Route::get('/memorizations', [TahfidzController::class, 'memorizations'])->name('memorizations.index');

    // Reports Management
    Route::get('/reports', [TahfidzController::class, 'reports'])->name('reports.index');

    // Guru Management
    Route::resource('gurus', AdminGuruController::class);
    Route::patch('/gurus/{guru}/toggle-status', [AdminGuruController::class, 'toggleStatus'])->name('gurus.toggle-status');
    Route::get('/gurus/search', [AdminGuruController::class, 'search'])->name('gurus.search');

    // Siswa Management
    Route::resource('siswas', AdminSiswaController::class);
    Route::patch('/siswas/{siswa}/toggle-status', [AdminSiswaController::class, 'toggleStatus'])->name('siswas.toggle-status');
    Route::patch('/siswas/{siswa}/graduate', [AdminSiswaController::class, 'graduate'])->name('siswas.graduate');
    Route::get('/siswas/search', [AdminSiswaController::class, 'search'])->name('siswas.search');
    Route::get('/siswas/by-kelas/{kelas}', [AdminSiswaController::class, 'getByKelas'])->name('siswas.by-kelas');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruGuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-siswa', [GuruGuruController::class, 'dataSiswa'])->name('data-siswa');
    Route::get('/siswa/{student}/hafalan', [GuruGuruController::class, 'lihatHafalan'])->name('siswa.hafalan');
    Route::get('/data-hafalan', [GuruGuruController::class, 'dataHafalan'])->name('data-hafalan');

    // Siswa Management (Guru)
    Route::get('/siswa', [GuruGuruController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/siswa/{student}', [GuruGuruController::class, 'siswaShow'])->name('siswa.show');

    // Hafalan Management
    Route::get('/hafalan', [GuruGuruController::class, 'hafalanIndex'])->name('hafalan.index');
    Route::get('/hafalan/{hafalan}', [MemorizationController::class, 'show'])->name('hafalan.show');
    Route::get('/hafalan/{hafalan}/edit', [MemorizationController::class, 'edit'])->name('hafalan.edit');
    Route::put('/hafalan/{hafalan}', [MemorizationController::class, 'update'])->name('hafalan.update');
    Route::delete('/hafalan/{hafalan}', [MemorizationController::class, 'destroy'])->name('hafalan.destroy');

    // Laporan Management (Guru)
    Route::get('/laporan', [GuruGuruController::class, 'laporanIndex'])->name('laporan.index');

    // Memorization Management
    Route::get('/siswa/{student}/setoran/create', [MemorizationController::class, 'create'])->name('setoran.create');
    Route::get('/siswa/{student}/setoran/create/{programId}', [MemorizationController::class, 'create'])->name('setoran.create-with-program');
    Route::post('/setoran', [MemorizationController::class, 'store'])->name('setoran.store');
    Route::get('/setoran/{entry}/edit', [MemorizationController::class, 'edit'])->name('setoran.edit');
    Route::put('/setoran/{entry}', [MemorizationController::class, 'update'])->name('setoran.update');
    Route::delete('/setoran/{entry}', [MemorizationController::class, 'destroy'])->name('setoran.destroy');
});

// Siswa/Orang Tua Routes
Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaSiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/hafalan', [SiswaSiswaController::class, 'hafalan'])->name('hafalan.index');
    Route::get('/hafalan/{program}', [SiswaSiswaController::class, 'hafalanDetail'])->name('hafalan.detail');
    Route::get('/laporan', [SiswaSiswaController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/{entry}', [SiswaSiswaController::class, 'laporanDetail'])->name('laporan.detail');
    Route::get('/laporan/export', [SiswaSiswaController::class, 'exportLaporan'])->name('laporan.export');
    Route::get('/progress', [SiswaSiswaController::class, 'progress'])->name('progress.index');

    // Profile Management (Siswa)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

// Legacy routes removed - using new structured routes above

require __DIR__.'/auth.php';
