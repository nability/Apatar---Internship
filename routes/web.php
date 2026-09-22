<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Dashboard & Modules (Protected by Auth) ───────────────────
Route::middleware(['auth'])->group(function () {
    // Redirect root to dashboard
    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/dashboard', fn() => view('dashboard'))
        ->name('dashboard');

    // ── Modul Kuantitatif (DDD) ──────────────────────────────────
    Route::prefix('kuantitatif')->name('kuantitatif.')->group(function () {
        Route::get('/', fn() => view('kuantitatif.index'))->name('index');
    });

    // ── Modul Kualitatif (Gyssens) ───────────────────────────────
    Route::prefix('kualitatif')->name('kualitatif.')->group(function () {
        Route::get('/', fn() => view('kualitatif.index'))->name('index');
    });

    // ── Modul PGA & AWaRe ────────────────────────────────────────
    Route::prefix('pga')->name('pga.')->group(function () {
        Route::get('/', fn() => view('pga.index'))->name('index');
    });

    // ── Integrasi SIMRS ──────────────────────────────────────────
    Route::prefix('integrasi')->name('integrasi.')->group(function () {
        Route::get('/farmasi',          fn() => view('integrasi.farmasi'))          ->name('farmasi');
        Route::get('/clinical-pathway', fn() => view('integrasi.clinical-pathway')) ->name('clinical-pathway');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
