<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/', fn () => redirect()->route('login'));

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
    Route::get('/suppliers/all', [SupplierController::class, 'all'])->name('suppliers.all');
});

Route::group(['middleware' => ['auth', 'role:user_admin']], function () {
    # COMPANIES
    Route::post('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    Route::get('/companies/restore', [CompanyController::class, 'removed'])->name('companies.removed');

    Route::post('/companies/{company}/address', [CompanyController::class, 'addAddress'])->name('companies.address.store');
    Route::delete('/companies/{company}/address/{address}', [CompanyController::class, 'removeAddress'])->name('companies.address.destroy');

    Route::post('/companies/{company}/contact', [CompanyController::class, 'addContact'])->name('companies.contact.store');
    Route::delete('/companies/{company}/contact/{contact}', [CompanyController::class, 'removeContact'])->name('companies.contact.destroy');

    # USERS
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('/users/restore', [UserController::class, 'removed'])->name('users.removed');

    Route::post('/users/{user}/address', [UserController::class, 'addAddress'])->name('users.address.store');
    Route::delete('/users/{user}/address/{address}', [UserController::class, 'removeAddress'])->name('users.address.destroy');

    Route::post('/users/{user}/contact', [UserController::class, 'addContact'])->name('users.contact.store');
    Route::delete('/users/{user}/contact/{contact}', [UserController::class, 'removeContact'])->name('users.contact.destroy');

    # SUPPLIERS
    Route::post('/suppliers/{supplier}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
    Route::get('/suppliers/restore', [SupplierController::class, 'removed'])->name('suppliers.removed');
});

Route::group(['middleware' => ['auth', 'role:super|user_admin|user_editor|user_viewer']], function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('users', UserController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::get('/chart/users', [UserController::class, 'chart'])->name('chart.users');
});
