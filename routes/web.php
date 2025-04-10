<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/lacak-pengaduan', function () {
    return view('pages.track-report');
})->name('track-report');

// Route::get('/pengaduan', function () {
//     return view('pages.create-report');
// })->name('report');

Route::get('/pengaduan', [ReportController::class, 'create'])->name('report');
Route::post('/pengaduan/kirim', [ReportController::class, 'store'])->name('report.store');
Route::get('/pengaduan/sukses/{token}', [ReportController::class, 'success'])->name('report.success');

// Route::get('/lacak-pengaduan', [ReportController::class, 'track'])->name('report.track');

Route::match(['get', 'post'], '/lacak-pengaduan', [ReportController::class, 'track'])->name('report.track');
