<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('login.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

Route::group(['middleware' => 'auth', 'role:super'], function () {
    Route::get('/companies/all', [CompanyController::class, 'all'])->name('companies.all');
    Route::get('/users/all', [UserController::class, 'all'])->name('users.all');
});

Route::group(['middleware' => ['auth', 'role:super|user_admin']], function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('users', UserController::class)->except(['show']);
});
