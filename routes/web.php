<?php

use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Hello';
});

// Route::middleware('guest', function () {
//     // Route::post('/login');
// });

Route::group(['middleware' => ['role:super']], function () {
    Route::get('/test', function () {
        $user = User::find(1);
        Auth::login($user);

        dd(Auth::check());

        $client = Client::first();
        $product = Product::first();

        dump($product);
        dump($user->hasPermissionTo('client_show'));

        return $product;
    })->name('test');
});

Route::get('/create_db_test_force', function () {
    DB::statement('CREATE DATABASE IF NOT EXISTS test_force');
});
