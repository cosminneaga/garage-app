<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');

    $user = User::find(1);

    dd($user->hasPermissionTo('clients_update'));

    return 'Hello World';
});

Route::get('/create_db_test_force', function () {
    DB::statement('CREATE DATABASE IF NOT EXISTS test_force');
});
