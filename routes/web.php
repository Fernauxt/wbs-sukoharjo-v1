<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashController;
use App\Http\Controllers\AdminReportController;
use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportTokenMail;

Route::get('/cek-waktu', function () {
    return Carbon::now()->toDateTimeString();
});

// Route for end-user (pengguna)
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/pengaduan', [ReportController::class, 'create'])->name('report');
Route::post('/pengaduan/kirim', [ReportController::class, 'store'])->name('report.store');
Route::get('/pengaduan/sukses/{token}', [ReportController::class, 'success'])->name('report.success');

Route::match(['get', 'post'], '/lacak-pengaduan', [ReportController::class, 'track'])->name('report.track');
// Route::match(['get', 'post'], '/lacak-pengaduan/{token}', [ReportController::class, 'trackByEmail'])->name('report.track.email');


// Route for admin (panel administrasi)
Route::get('/admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminDashController::class, 'index'])->name('admin.dashboard');
    Route::get('/laporan', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/laporan/{id}', [AdminReportController::class, 'show'])->name('admin.reports.show');
    Route::post('/laporan/{id}/update', [AdminReportController::class, 'update'])->name('admin.reports.update');
});
