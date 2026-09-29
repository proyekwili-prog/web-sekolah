
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkstrakulikulerController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileSekolahController;
use App\Http\Controllers\SiswaController;
use App\Models\Ekstrakulikuler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'publicDashboard'])->name('public.dashboard');

// Route::middleware('guest')->group(function () {
//     Route::('/login', [AuthController::class, 'index'])
//         ->name('login');

    Route::get('/', [AuthController::class, 'index'])
        ->name('admin.login');

    Route::post('Login-proses', [AuthController::class, 'processLogin'])
       ->name('admin.login.proses');
// });

//lOGOUT
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// ROUTE GROUP ADMIN (WAJIB LOGIN / AUTH MIDDLEWARE)
// =========================================================================

route::middleware('auth')->prefix('admin')->group(function () {

    //1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    //2. Profile sekolah
    Route::get('/admin/Profile', [ProfileSekolahController::class, 'index'])
        ->name('admin.profile');

    Route::put('/admin/Profile', [ProfileSekolahController::class, 'update'])
        ->name('admin.profile');

    Route::post('/admin/Profile/photo', [ProfileSekolahController::class, 'updatePhoto'])
        ->name('admin.profile.photo');

});

    // ================= SISWA =================
Route::prefix('siswa')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])
    ->name('admin.siswa.index');

    Route::get('/siswa/create', [SiswaController::class, 'addEdit'])
        ->name('admin.siswa.create');

    Route::get('/siswa/{id}/edit', [SiswaController::class, 'addEdit'])
        ->name('admin.siswa.edit');

    Route::post('/siswa/save/{id?}', [SiswaController::class, 'save'])
        ->name('admin.siswa.save');

    Route::delete('/siswa/{id}', [SiswaController::class, 'delete'])
        ->name('admin.siswa.destroy');

});

Route::prefix('ekstrakulikuler')->group(function () {

    Route::get('/', [EkstrakulikulerController::class, 'index'])
        ->name('admin.ekstrakulikuler.index');
    Route::get('/add-edit/{id}', [EkstrakulikulerController::class, 'addEdit'])
        ->name('admin.ekstrakulikuler.addEdit');
    Route::post('/save{id?}', [EkstrakulikulerController::class, 'save'])
        ->name('admin.ekstrakulikuler.save');
    Route::get('/{id}', [EkstrakulikulerController::class, 'index'])
        ->name('admin.ekstrakulikuler.show');
    Route::get('/{id}', [EkstrakulikulerController::class, 'index'])
        ->name('admin.ekstrakulikuler.delete');


    // ================= GURU =================

    Route::get('/admin/guru', [GuruController::class, 'index'])
        ->name('admin.guru');

    Route::get('/admin/guru/create', [GuruController::class, 'create'])
        ->name('admin.guru.create');

    Route::post('/admin/guru', [GuruController::class, 'store'])
        ->name('admin.guru.store');

    Route::get('/admin/guru/{id}/edit', [GuruController::class, 'edit'])
        ->name('admin.guru.edit');

    Route::put('/admin/guru/{id}', [GuruController::class, 'update'])
        ->name('admin.guru.update');

    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])
        ->name('admin.guru.destroy');

    Route::get('/galeri', [GaleriController::class, 'index'])
        ->name('admin.galeri');

    Route::get('/berita', [BeritaController::class, 'index'])
        ->name('admin.berita');

});
