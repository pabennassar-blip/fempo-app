<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\EmpresaController;

// Serve index.html as home page
Route::get('/', function () {
    $indexPath = public_path('index.html');
    if (File::exists($indexPath)) {
        return response(File::get($indexPath), 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
    return view('welcome');
})->name('home');

// Serve chat.html
Route::get('/chat.html', function () {
    $chatPath = public_path('chat.html');
    if (File::exists($chatPath)) {
        return response(File::get($chatPath), 200)
            ->header('Content-Type', 'text/html; charset=utf-8');
    }
    abort(404);
})->name('chat');

// Admin Backend Routes
Route::get('/backend/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/backend/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/backend/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['web', 'auth', 'admin'])->prefix('backend')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::resource('users', \App\Http\Controllers\Admin\AdminUsersController::class);
    Route::get('users/import/form', [\App\Http\Controllers\Admin\AdminUsersController::class, 'importForm'])->name('users.import-form');
    Route::post('users/import', [\App\Http\Controllers\Admin\AdminUsersController::class, 'import'])->name('users.import');

    // Companies Management
    Route::resource('companies', \App\Http\Controllers\Admin\AdminCompaniesController::class);
    Route::get('companies/import/form', [\App\Http\Controllers\Admin\AdminCompaniesController::class, 'importForm'])->name('companies.import-form');
    Route::post('companies/import', [\App\Http\Controllers\Admin\AdminCompaniesController::class, 'import'])->name('companies.import');

    // RAs Management
    Route::resource('ras', \App\Http\Controllers\Admin\AdminRasController::class);
    Route::get('ras/import/form', [\App\Http\Controllers\Admin\AdminRasController::class, 'importForm'])->name('ras.import-form');
    Route::post('ras/import', [\App\Http\Controllers\Admin\AdminRasController::class, 'import'])->name('ras.import');

    // Jornades Management
    Route::resource('jornades', \App\Http\Controllers\Admin\AdminJornadaController::class);
    Route::get('jornades/import/form', [\App\Http\Controllers\Admin\AdminJornadaController::class, 'importForm'])->name('jornades.import-form');
    Route::post('jornades/import', [\App\Http\Controllers\Admin\AdminJornadaController::class, 'import'])->name('jornades.import');

    // Contracts Management
    Route::resource('contracts', \App\Http\Controllers\Admin\AdminContractsController::class);
    Route::get('contracts/import/form', [\App\Http\Controllers\Admin\AdminContractsController::class, 'importForm'])->name('contracts.import-form');
    Route::post('contracts/import', [\App\Http\Controllers\Admin\AdminContractsController::class, 'import'])->name('contracts.import');
});


