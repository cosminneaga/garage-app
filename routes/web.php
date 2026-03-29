<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('login.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'show'])->name('login.show');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.authenticate');
});

Route::group(['middleware' => ['role:admin_super|user_admin']], function () {
    Route::get('/companies', [CompanyController::class, 'showOwn'])->name('company.showOwn');
    Route::get('/companies/all', [CompanyController::class, 'showAll'])->name('company.showAll');

    Route::get('/company/{company}', [CompanyController::class, 'show'])->name('company.show');
});
