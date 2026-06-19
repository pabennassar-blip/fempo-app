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
});


