<?php
use App\Http\Controllers\{AdminController, DeploymentController, HomeController, PembayaranController};
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/kas', [PembayaranController::class, 'index'])->name('kas.index');
    Route::get('/kas/{kas}/bayar', [PembayaranController::class, 'show'])->name('kas.bayar');
    Route::post('/kas/{kas}/bayar', [PembayaranController::class, 'store'])->name('kas.store');

    Route::middleware(AdminOnly::class)->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/kas', [AdminController::class, 'storeKas'])->name('kas.store');
        Route::post('/pembayaran/{pembayaran}/verifikasi', [AdminController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/pembayaran/{pembayaran}/tolak', [AdminController::class, 'tolak'])->name('tolak');
        Route::get('/deployment', [DeploymentController::class, 'edit'])->name('deployment');
        Route::post('/deployment', [DeploymentController::class, 'update'])->name('deployment.update');
    });
});
