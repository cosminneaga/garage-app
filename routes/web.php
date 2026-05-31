<?php

declare(strict_types=1);

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

// USER_ADMIN
Route::group(['middleware' => ['auth', 'role:super|user_admin']], function () {

    // COMPANIES
    Route::post('/companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    Route::get('/companies/restore', [CompanyController::class, 'removed'])->name('companies.removed');

    Route::delete('/companies/{company}/address/{address}', [AddressController::class, 'destroy'])->name('companies.address.destroy');
    Route::delete('/companies/{company}/contact/{contact}', [ContactController::class, 'destroy'])->name('companies.contact.destroy');
    Route::delete('/companies/{company}/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('companies.supplier.destroy');

    // USERS
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('/users/restore', [UserController::class, 'removed'])->name('users.removed');

    Route::post('/users/{user}/address', [AddressController::class, 'store'])->name('users.address.store');
    Route::get('/users/{user}/address/{address}', [AddressController::class, 'edit'])->name('users.address.edit');
    Route::delete('/users/{user}/address/{address}', [AddressController::class, 'destroy'])->name('users.address.destroy');

    Route::post('/users/{user}/contact', [ContactController::class, 'store'])->name('users.contact.store');
    Route::get('/users/{user}/contact/{contact}', [ContactController::class, 'edit'])->name('users.contact.edit');
    Route::delete('/users/{user}/contact/{contact}', [ContactController::class, 'destroy'])->name('users.contact.destroy');

    // SUPPLIERS
    Route::post('/suppliers/{supplier}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
    Route::get('/suppliers/restore', [SupplierController::class, 'removed'])->name('suppliers.removed');

    Route::delete('/suppliers/{supplier}/address/{address}', [AddressController::class, 'destroy'])->name('suppliers.address.destroy');
    Route::delete('/suppliers/{supplier}/contact/{contact}', [ContactController::class, 'destroy'])->name('suppliers.contact.destroy');
});

// USER_ADMIN|USER_EDITOR
Route::group(['middleware' => ['auth', 'role:super|user_admin|user_editor']], function () {

    // COMPANIES
    Route::get('/companies/{company}/address/{address}', [AddressController::class, 'edit'])->name('companies.address.edit');
    Route::post('/companies/{company}/address', [AddressController::class, 'store'])->name('companies.address.store');

    Route::get('/companies/{company}/contact/{contact}', [ContactController::class, 'edit'])->name('companies.contact.edit');
    Route::post('/companies/{company}/contact', [ContactController::class, 'store'])->name('companies.contact.store');

    Route::post('/companies/{company}/suppliers', [SupplierController::class, 'store'])->name('companies.supplier.store');
    Route::get('/companies/{company}/suppliers/{supplier}', [SupplierController::class, 'edit'])->name('companies.supplier.edit');
    Route::put('/companies/{company}/suppliers/{supplier}', [SupplierController::class, 'update'])->name('companies.supplier.update');

    Route::put('/companies/{company}/user', [CompanyController::class, 'userAttach'])->name('companies.user.attach');
    Route::post('/companies/{company}/user', [CompanyController::class, 'userStore'])->name('companies.user.store');
    Route::delete('/companies/{company}/user/{user}', [CompanyController::class, 'userDestroy'])->name('companies.user.destroy');

    // SUPPLIERS
    Route::get('/suppliers/{supplier}/address/{address}', [AddressController::class, 'edit'])->name('suppliers.address.edit');
    Route::post('/suppliers/{supplier}/address', [AddressController::class, 'store'])->name('suppliers.address.store');

    Route::get('/suppliers/{supplier}/contact/{contact}', [ContactController::class, 'edit'])->name('suppliers.contact.edit');
    Route::post('/suppliers/{supplier}/contact', [ContactController::class, 'store'])->name('suppliers.contact.store');
});

// ALL USERS
Route::group(['middleware' => ['auth', 'role:super|user_admin|user_editor|user_viewer']], function () {
    Route::resource('companies', CompanyController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');

    Route::get('/chart/users', [UserController::class, 'chart'])->name('chart.users');

    Route::get('/users/profile', [ProfileController::class, 'edit'])->name('users.profile.edit');
    Route::put('/users/{user}/profile', [ProfileController::class, 'update'])->name('users.profile.update');
});

// ADMINISTRATION
// !NOTE: seems like after another build this functionality came along and point the unauthorized users to 404, keep an eye on it...
Route::group(['middleware' => 'auth', 'role:super'], function () {
    Route::get('/administration/company/all', [CompanyController::class, 'all'])->name('companies.all');
    Route::get('/administration/user/all', [UserController::class, 'all'])->name('users.all');
    Route::get('/administration/supplier/all', [SupplierController::class, 'all'])->name('suppliers.all');

    Route::delete('/administration/supplier/{supplier}', [SupplierController::class, 'destroyUnrelated'])->name('suppliers.destroy');
});
