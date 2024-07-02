<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Assure-toi que 'app' est le nom de ta vue principale Vue.js
})->where('any', '.*');

