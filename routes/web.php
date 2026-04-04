<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('login.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'show'])->name('login');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
});

Route::group(['middleware' => ['auth', 'role:admin_super|user_admin']], function () {
    Route::get('/companies/all', [CompanyController::class, 'all'])->name('companies.all');
    Route::resource('companies', CompanyController::class);
});
