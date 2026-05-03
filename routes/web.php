<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
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

# USER_ADMIN
Route::group(['middleware' => ['auth', 'role:super|user_admin']], function () {
    # COMPANIES
    Route::post('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    Route::get('/companies/restore', [CompanyController::class, 'removed'])->name('companies.removed');

    Route::get('/companies/{company}/address/{address}', [AddressController::class, 'show'])->name('companies.address.show');
    Route::post('/companies/{company}/address', [AddressController::class, 'store'])->name('companies.address.store');
    Route::delete('/companies/{company}/address/{address}', [AddressController::class, 'destroy'])->name('companies.address.destroy');

    Route::get('/companies/{company}/contact/{contact}', [ContactController::class, 'show'])->name('companies.contact.show');
    Route::post('/companies/{company}/contact', [ContactController::class, 'store'])->name('companies.contact.store');
    Route::delete('/companies/{company}/contact/{contact}', [ContactController::class, 'destroy'])->name('companies.contact.destroy');

    Route::get('/companies/{company}/suppliers/{supplier}', [CompanyController::class, 'showSupplier'])->name('companies.supplier.show');
    Route::post('/companies/{company}/supplier', [CompanyController::class, 'addSupplier'])->name('companies.supplier.store');
    Route::delete('/companies/{company}/supplier/{supplier}', [CompanyController::class, 'removeSupplier'])->name('companies.supplier.destroy');


    # USERS
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('/users/restore', [UserController::class, 'removed'])->name('users.removed');

    Route::get('/users/{user}/address/{address}', [AddressController::class, 'show'])->name('users.address.show');
    Route::post('/users/{user}/address', [AddressController::class, 'store'])->name('users.address.store');
    Route::delete('/users/{user}/address/{address}', [AddressController::class, 'destroy'])->name('users.address.destroy');

    Route::get('/users/{user}/contact/{contact}', [ContactController::class, 'show'])->name('users.contact.show');
    Route::post('/users/{user}/contact', [ContactController::class, 'store'])->name('users.contact.store');
    Route::delete('/users/{user}/contact/{contact}', [ContactController::class, 'destroy'])->name('users.contact.destroy');


    # SUPPLIERS
    Route::post('/suppliers/{supplier}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
    Route::get('/suppliers/restore', [SupplierController::class, 'removed'])->name('suppliers.removed');

    Route::get('/suppliers/{supplier}/address/{address}', [AddressController::class, 'show'])->name('suppliers.address.show');
    Route::post('/suppliers/{supplier}/address', [AddressController::class, 'store'])->name('suppliers.address.store');
    Route::delete('/suppliers/{supplier}/address/{address}', [AddressController::class, 'destroy'])->name('suppliers.address.destroy');

    Route::get('/suppliers/{supplier}/contact/{contact}', [ContactController::class, 'show'])->name('suppliers.contact.show');
    Route::post('/suppliers/{supplier}/contact', [ContactController::class, 'store'])->name('suppliers.contact.store');
    Route::delete('/suppliers/{supplier}/contact/{contact}', [ContactController::class, 'destroy'])->name('suppliers.contact.destroy');
});


# ALL USERS
Route::group(['middleware' => ['auth', 'role:super|user_admin|user_editor|user_viewer']], function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('users', UserController::class);

    Route::get('/chart/users', [UserController::class, 'chart'])->name('chart.users');
});

# ADMINISTRATION
// !NOTE: seems like after another build this functionality came along and point the unauthorized users to 404, keep an eye on it...
Route::group(['middleware' => 'auth', 'role:super'], function () {
    Route::get('/administration/company/all', [CompanyController::class, 'all'])->name('companies.all');
    Route::get('/administration/user/all', [UserController::class, 'all'])->name('users.all');
    Route::get('/administration/supplier/all', [SupplierController::class, 'all'])->name('suppliers.all');
});
