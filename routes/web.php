<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('dashboard')->group(function () {
    Route::get('/home', [DashboardController::class, 'index']);

    Route::controller(AnalyticsController::class)->group(function () {
        Route::get('/sales', 'predictSales')->name('analytics.sales');
        Route::get('/recommendations/{customer_id}', 'recommendProducts')->name('analytics.recommendations');
        Route::get('/report', 'exportPDF')->name('analytics.pdf');
    });
});

Route::get('/customer/{id}/points', [CustomerController::class, 'showPoints']);
