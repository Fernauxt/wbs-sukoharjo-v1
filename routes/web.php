<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/lacak-pengaduan', function () {
    return view('pages.track-report');
})->name('track-report');
