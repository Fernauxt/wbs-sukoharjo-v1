<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminAuthController;


// Route for end-user (pengguna)
Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/pengaduan', [ReportController::class, 'create'])->name('report');
Route::post('/pengaduan/kirim', [ReportController::class, 'store'])->name('report.store');
Route::get('/pengaduan/sukses/{token}', [ReportController::class, 'success'])->name('report.success');

Route::match(['get', 'post'], '/lacak-pengaduan', [ReportController::class, 'track'])->name('report.track');


// Route for admin (panel administrasi)
// routes/web.php

Route::get('/admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', fn() => 'Halo Admin!')->name('admin.dashboard');
    // Nanti route admin lainnya juga masuk sini ya
});
