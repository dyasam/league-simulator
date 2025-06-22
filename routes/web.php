<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('teams');
});

Route::get('/simulations', function () {
    return view('simulations');
});
