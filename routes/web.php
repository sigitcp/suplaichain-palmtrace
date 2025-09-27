<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index');
});

Route::get('/users', function () {
    return view('user.index');
});

Route::get('/login', function () {
    return view('auth.login');
});