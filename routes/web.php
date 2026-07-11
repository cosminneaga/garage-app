<?php

declare(strict_types=1);

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperController;
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

Route::controller(AdministratorController::class)
    ->middleware(['auth', 'role:super'])
    ->group(function () {
        Route::resource('administrators', AdministratorController::class)->except(['show', 'destroy']);
    });

Route::controller(ManagerController::class)
    ->middleware(['auth', 'role:administrator'])
    ->group(function () {
        Route::resource('managers', ManagerController::class)->except('show');
        Route::get('/managers/restore', 'removed')->name('managers.removed');
        Route::post('/managers/{id}/restore', 'restore')->name('managers.restore');
    });

Route::controller(UserController::class)
    ->middleware(['auth', 'role:super|administrator|manager'])
    ->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::get('/users/restore', 'removed')->name('users.removed');
        Route::get('/users/chart', 'chart')->name('users.chart');
        Route::post('/users/{id}/restore', 'restore')->name('users.restore');

        # permissions
        Route::put('/users/{user}/permission/{name}', 'assignPermission')->name('users.permission.assign');
        Route::delete('/users/{user}/permission/{name}', 'revokePermission')->name('users.permission.revoke');

        # companies
        Route::post('/users/companies/{company}', 'modelStore')->name('users.companies.store');
        Route::put('/users/{user}/companies/{company}', 'modelAttach')->name('users.companies.attach');
        Route::delete('/users/{user}/companies/{company}', 'modelDetach')->name('users.companies.destroy');
    });

Route::controller(CompanyController::class)
    ->middleware(['auth', 'role:super|administrator|manager|user'])
    ->group(function () {
        Route::resource('companies', CompanyController::class)->except('show');
        Route::get('/companies/restore', 'removed')->name('companies.removed');
        Route::post('/companies/{company}/restore', 'restore')->name('companies.restore');
    });

Route::controller(ProfileController::class)
    ->middleware(['auth', 'role:super|administrator|manager|user'])
    ->group(function () {
        Route::get('/profile/users', 'edit')->name('profile.users.edit');
        Route::put('/profile/users/{user}', 'update')->name('profile.users.update');
    });

Route::controller(SupplierController::class)
    ->middleware(['auth', 'role:super|administrator|manager|user'])
    ->group(function () {
        Route::get('/suppliers/{supplier}', 'editSingle')->name('suppliers.edit');
        Route::get('/suppliers/restore', 'removed')->name('suppliers.removed');
        Route::post('/suppliers/{supplier}/restore', 'restore')->name('suppliers.restore');

        # companies
        Route::post('/suppliers/companies/{company}', 'modelStore')->name('suppliers.companies.store');
        Route::get('/suppliers/{supplier}/companies/{company}', 'edit')->name('suppliers.companies.edit');
        Route::put('/suppliers/{supplier}/companies/{company}', 'update')->name('suppliers.companies.update');
        Route::delete('/suppliers/{supplier}/companies/{company}', 'destroy')->name('suppliers.companies.destroy');
    });

Route::controller(AddressController::class)
    ->middleware(['auth', 'role:super|administrator|manager|user'])
    ->group(function () {
        # users
        Route::get('/addresses/{address}/users/{user}', 'edit')->name('addresses.users.edit');
        Route::post('/addresses/users/{user}', 'store')->name('addresses.users.store');
        Route::put('/addresses/{address}/users/{user}', 'update')->name('addresses.users.update');
        Route::delete('/addresses/{address}/users/{user}', 'destroy')->name('addresses.users.destroy');

        # companies
        Route::get('/addresses/{address}/companies/{company}', 'edit')->name('addresses.companies.edit');
        Route::post('/addresses/companies/{company}', 'store')->name('addresses.companies.store');
        Route::put('/addresses/{address}/companies/{company}', 'update')->name('addresses.companies.update');
        Route::delete('/addresses/{address}/companies/{company}', 'destroy')->name('addresses.companies.destroy');

        # suppliers
        Route::get('/addresses/{address}/suppliers/{supplier}', 'edit')->name('addresses.suppliers.edit');
        Route::post('/addresses/suppliers/{supplier}', 'store')->name('addresses.suppliers.store');
        Route::put('/addresses/{address}/suppliers/{supplier}', 'update')->name('addresses.suppliers.update');
        Route::delete('/addresses/{address}/suppliers/{supplier}', 'destroy')->name('addresses.suppliers.destroy');
    });

Route::controller(ContactController::class)
    ->middleware(['auth', 'role:super|administrator|manager|user'])
    ->group(function () {
        # users
        Route::get('/contacts/{contact}/users/{user}', 'edit')->name('contacts.users.edit');
        Route::post('/contacts/users/{user}', 'store')->name('contacts.users.store');
        Route::put('/contacts/{contact}/users/{user}', 'update')->name('contacts.users.update');
        Route::delete('/contacts/{contact}/users/{user}', 'destroy')->name('contacts.users.destroy');

        # companies
        Route::get('/contacts/{contact}/companies/{company}', 'edit')->name('contacts.companies.edit');
        Route::post('/contacts/companies/{company}', 'store')->name('contacts.companies.store');
        Route::put('/contacts/{contact}/companies/{company}', 'update')->name('contacts.companies.update');
        Route::delete('/contacts/{contact}/companies/{company}', 'destroy')->name('contacts.companies.destroy');

        # suppliers
        Route::get('/contacts/{contact}/suppliers/{supplier}', 'edit')->name('contacts.suppliers.edit');
        Route::post('/contacts/suppliers/{supplier}', 'store')->name('contacts.suppliers.store');
        Route::put('/contacts/{contact}/suppliers/{supplier}', 'update')->name('contacts.suppliers.contact.update');
        Route::delete('/contacts/{contact}/suppliers/{supplier}', 'destroy')->name('contacts.suppliers.destroy');
    });

// ADMINISTRATION
// Route::group(['middleware' => 'auth', 'role:super'], function () {
//     Route::get('/root/users', [])

//     Route::get('/root/company/all', [CompanyController::class, 'all'])->name('companies.all');
//     Route::get('/root/user/all', [UserController::class, 'all'])->name('users.all');

//     Route::get('/root/supplier/all', [SupplierController::class, 'all'])->name('suppliers.all');
//     Route::get('/root/suppliers/{supplier}/edit', [SupplierController::class, 'editSingle'])->name('suppliers.edit');
//     Route::put('/root/suppliers/{supplier}/edit', [SupplierController::class, 'updateSingle'])->name('suppliers.update');
//     Route::delete('/root/supplier/{supplier}', [SupplierController::class, 'destroySingle'])->name('suppliers.destroy');
// });

Route::controller(SuperController::class)
    ->middleware(['auth', 'role:super'])
    ->group(function () {
        Route::get('/super/users', 'users')->name('super.users.all');
        Route::get('/super/companies', 'companies')->name('super.companies.all');
        Route::get('/super/suppliers', 'suppliers')->name('super.suppliers.all');
    });
