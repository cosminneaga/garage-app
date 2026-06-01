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

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('login.logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

Route::controller(CompanyController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::resource('companies', CompanyController::class)->except('show');
        Route::get('/companies/restore', 'removed')->name('companies.removed');
        Route::post('/companies/{company}/restore', 'restore')->name('companies.restore');
        Route::post('/companies/{company}/user', 'userStore')->name('companies.user.store');
        Route::put('/companies/{company}/user', 'userAttach')->name('companies.user.attach');
        Route::delete('/companies/{company}/user/{user}', 'userDestroy')->name('companies.user.destroy');
    });

Route::controller(UserController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::get('/users/restore', 'removed')->name('users.removed');
        Route::get('/chart/users', 'chart')->name('chart.users');
        Route::post('/users/{id}/restore', 'restore')->name('users.restore');
    });

Route::controller(ProfileController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::get('/users/profile', 'edit')->name('users.profile.edit');
        Route::put('/users/{user}/profile', 'update')->name('users.profile.update');
    });

Route::controller(SupplierController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::get('/suppliers/restore', 'removed')->name('suppliers.removed');
        Route::get('/companies/{company}/suppliers/{supplier}', 'edit')->name('companies.supplier.edit');
        Route::post('/suppliers/{supplier}/restore', 'restore')->name('suppliers.restore');
        Route::post('/companies/{company}/suppliers', 'store')->name('companies.supplier.store');
        Route::put('/companies/{company}/suppliers/{supplier}', 'update')->name('companies.supplier.update');
        Route::delete('/companies/{company}/supplier/{supplier}', 'destroy')->name('companies.supplier.destroy');
    });

Route::controller(AddressController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::get('/users/{user}/address/{address}', 'edit')->name('users.address.edit');
        Route::get('/companies/{company}/address/{address}', 'edit')->name('companies.address.edit');
        Route::get('/suppliers/{supplier}/address/{address}', 'edit')->name('suppliers.address.edit');
        Route::post('/users/{user}/address', 'store')->name('users.address.store');
        Route::post('/companies/{company}/address', 'store')->name('companies.address.store');
        Route::post('/suppliers/{supplier}/address', 'store')->name('suppliers.address.store');
        Route::delete('/users/{user}/address/{address}', 'destroy')->name('users.address.destroy');
        Route::delete('/companies/{company}/address/{address}', 'destroy')->name('companies.address.destroy');
        Route::delete('/suppliers/{supplier}/address/{address}', 'destroy')->name('suppliers.address.destroy');
    });

Route::controller(ContactController::class)
    ->middleware(['auth', 'role:super|user_admin|user_editor|user_viewer'])
    ->group(function () {
        Route::get('/users/{user}/contact/{contact}', 'edit')->name('users.contact.edit');
        Route::get('/companies/{company}/contact/{contact}', 'edit')->name('companies.contact.edit');
        Route::get('/suppliers/{supplier}/contact/{contact}', 'edit')->name('suppliers.contact.edit');
        Route::post('/users/{user}/contact', 'store')->name('users.contact.store');
        Route::post('/companies/{company}/contact', 'store')->name('companies.contact.store');
        Route::post('/suppliers/{supplier}/contact', 'store')->name('suppliers.contact.store');
        Route::delete('/users/{user}/contact/{contact}', 'destroy')->name('users.contact.destroy');
        Route::delete('/companies/{company}/contact/{contact}', 'destroy')->name('companies.contact.destroy');
        Route::delete('/suppliers/{supplier}/contact/{contact}', 'destroy')->name('suppliers.contact.destroy');
    });

// ADMINISTRATION
// !NOTE: seems like after another build this functionality came along and point the unauthorized users to 404, keep an eye on it...
Route::group(['middleware' => 'auth', 'role:super'], function () {
    Route::get('/administration/company/all', [CompanyController::class, 'all'])->name('companies.all');
    Route::get('/administration/user/all', [UserController::class, 'all'])->name('users.all');

    Route::get('/administration/supplier/all', [SupplierController::class, 'all'])->name('suppliers.all');
    Route::get('/administration/suppliers/{supplier}/edit', [SupplierController::class, 'editSingle'])->name('suppliers.edit');
    Route::put('/administration/suppliers/{supplier}/edit', [SupplierController::class, 'updateSingle'])->name('suppliers.update');
    Route::delete('/administration/supplier/{supplier}', [SupplierController::class, 'destroySingle'])->name('suppliers.destroy');
});
