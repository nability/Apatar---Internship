<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleAccessController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleSwitcherController;
use App\Http\Controllers\RoleSelectionController;
use Illuminate\Support\Facades\Route;

// ── Dashboard & Modules (Protected by Auth) ───────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/select-role', [RoleSelectionController::class, 'show'])->name('role.select');
    Route::post('/select-role', [RoleSelectionController::class, 'select'])->name('role.select.confirm');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Modul Kuantitatif (DDD) ──────────────────────────────────
    Route::prefix('kuantitatif')->name('kuantitatif.')->middleware('module.access:kuantitatif')->group(function () {
        Route::get('/', fn() => view('kuantitatif.index'))->name('index');
    });

    // ── Modul Kualitatif (Gyssens) ───────────────────────────────
    Route::prefix('kualitatif')->name('kualitatif.')->middleware('module.access:kualitatif')->group(function () {
        Route::get('/', fn() => view('kualitatif.index'))->name('index');
    });

    // ── Modul PGA & AWaRe ────────────────────────────────────────
    Route::prefix('pga')->name('pga.')->middleware('module.access:pga')->group(function () {
        Route::get('/', fn() => view('pga.index'))->name('index');
    });

    // ── Integrasi SIMRS ──────────────────────────────────────────
    Route::prefix('integrasi')->name('integrasi.')->group(function () {
        Route::get('/farmasi', fn() => view('integrasi.farmasi'))
            ->middleware('module.access:farmasi')
            ->name('farmasi');
        Route::get('/clinical-pathway', fn() => view('integrasi.clinical-pathway'))
            ->middleware('module.access:clinical_pathway')
            ->name('clinical-pathway');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/switch-role/{role}', [RoleSwitcherController::class, 'switch'])->name('role.switch');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/akses-role', [RoleAccessController::class, 'index'])->name('access.index');
        Route::put('/akses-role/{role}', [RoleAccessController::class, 'update'])->name('access.update');
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('/users/{user}/roles', [UserManagementController::class, 'updateRoles'])->name('users.roles.update');
    });
});

require __DIR__.'/auth.php';
