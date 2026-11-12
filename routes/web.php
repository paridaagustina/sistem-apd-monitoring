<?php

use App\Http\Controllers\Ccv\CcvFormController;
use App\Http\Controllers\Admin\CcvDashboardController;
use App\Http\Controllers\ApdDashboardController;
use App\Http\Controllers\ApdMonitoringController;
use App\Http\Controllers\Admin\ApdItemController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Worker\FieldReportController;
use App\Http\Controllers\Admin\AdminFieldReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ==================================================
// HALAMAN AWAL
// ==================================================

Route::get('/', function () {
    return view('welcome');
});

// ==================================================
// DASHBOARD BERDASARKAN ROLE
// ==================================================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function (Request $request) {

        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('pekerja.dashboard');

    })->name('dashboard');

    // Pengaturan profil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// ==================================================
// DASHBOARD ADMIN
// ==================================================

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [
            ApdDashboardController::class,
            'admin',
        ])->name('dashboard');

        // ------------------------------------------
        // MASTER APD
        // ------------------------------------------

        Route::get('/apd-items', [ApdItemController::class, 'index'])
            ->name('apd-items.index');

        Route::get('/apd-items/create', [ApdItemController::class, 'create'])
            ->name('apd-items.create');

        Route::post('/apd-items', [ApdItemController::class, 'store'])
            ->name('apd-items.store');

        Route::get('/apd-items/{apdItem}/edit', [ApdItemController::class, 'edit'])
            ->name('apd-items.edit');

        Route::put('/apd-items/{apdItem}', [ApdItemController::class, 'update'])
            ->name('apd-items.update');

        Route::patch(
            '/apd-items/{apdItem}/toggle-status',
            [ApdItemController::class, 'toggleStatus']
        )->name('apd-items.toggle-status');

        // ------------------------------------------
        // DATA PEKERJA
        // ------------------------------------------

        Route::get('/workers', [WorkerController::class, 'index'])
            ->name('workers.index');

        Route::get('/workers/create', [WorkerController::class, 'create'])
            ->name('workers.create');

        Route::post('/workers', [WorkerController::class, 'store'])
            ->name('workers.store');

        Route::get('/workers/{worker}/edit', [WorkerController::class, 'edit'])
            ->name('workers.edit');

        Route::put('/workers/{worker}', [WorkerController::class, 'update'])
            ->name('workers.update');

        Route::patch(
            '/workers/{worker}/toggle-status',
            [WorkerController::class, 'toggleStatus']
        )->name('workers.toggle-status');

        // ------------------------------------------
        // LAPORAN LAPANGAN
        // ------------------------------------------

        Route::get('/field-reports', [
            AdminFieldReportController::class,
            'index',
        ])->name('field-reports.index');

        Route::get('/field-reports/{fieldReport}', [
            AdminFieldReportController::class,
            'show',
        ])->name('field-reports.show');

        Route::get('/field-reports/{fieldReport}/video', [
            AdminFieldReportController::class,
            'video',
        ])->name('field-reports.video');

        Route::patch('/field-reports/{fieldReport}/status', [
            AdminFieldReportController::class,
            'updateStatus',
        ])->name('field-reports.update-status');

        Route::get('/field-reports/{fieldReport}/download', [
            AdminFieldReportController::class,
            'download',
        ])->name('field-reports.download');

        // ------------------------------------------
        // CCV - DASHBOARD ADMIN
        // Admin hanya melihat grafik dan laporan
        // ------------------------------------------

        Route::get('/ccv', [
            CcvDashboardController::class,
            'index',
        ])->name('ccv.index');

        Route::get('/ccv/{observation}', [
            CcvDashboardController::class,
            'show',
        ])->name('ccv.show');

    });

// ==================================================
// DASHBOARD PEKERJA LAPANGAN
// ==================================================

Route::middleware(['auth', 'role:pekerja_lapangan'])
    ->prefix('pekerja')
    ->name('pekerja.')
    ->group(function () {

        // Dashboard Pekerja
        Route::get('/dashboard', [
            ApdDashboardController::class,
            'pekerja',
        ])->name('dashboard');

        // ------------------------------------------
        // MONITORING APD
        // ------------------------------------------

        Route::get('/monitoring', [
            ApdMonitoringController::class,
            'index',
        ])->name('monitoring');

        Route::post('/monitoring', [
            ApdMonitoringController::class,
            'store',
        ])->middleware('throttle:10,1')
          ->name('monitoring.store');

        // ------------------------------------------
        // LAPORAN VIDEO LAPANGAN
        // ------------------------------------------

        Route::get('/field-reports', [
            FieldReportController::class,
            'index',
        ])->name('field-reports.index');

        Route::post('/field-reports', [
            FieldReportController::class,
            'store',
        ])->middleware('throttle:5,1')
          ->name('field-reports.store');

        // ------------------------------------------
        // CCV - FORMULIR PEKERJA
        // Pegawai mengisi formulir CCV
        // ------------------------------------------

        Route::get('/ccv', [
            CcvFormController::class,
            'create',
        ])->name('ccv.create');

        Route::post('/ccv', [
            CcvFormController::class,
            'store',
        ])->middleware('throttle:10,1')
          ->name('ccv.store');

    });

// ==================================================
// AUTHENTICATION
// ==================================================

require __DIR__.'/auth.php';