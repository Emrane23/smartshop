<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
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
Route::get('/about', function () {
    return view('frontoffice.pages.about');
})->name('about');
Route::get('/products/{id}', [HomeController::class, 'showProduct'])->name('frontoffice.products.show');


Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest:customer,web');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show')->middleware('guest:customer,web');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest:customer,web');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show')->middleware('guest:customer,web');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/customer-area', [CustomerController::class, 'CustomerArea'])->name('customer.area')->middleware('auth:customer');
Route::post('/sendRating', [RatingController::class, 'sendRating'])->name('send.rating')->middleware('auth:customer');
Route::get('/ratings/{productId}', [RatingController::class, 'getRatingDistribution']);

Route::middleware(['auth:web,customer'])->group(function () {
    Route::get('/cart', function () {
        return view('frontoffice.pages.cart');
    })->name('cart.show');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
});


Route::prefix('dashboard')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.home');
        Route::resource('products', ProductController::class);
        Route::post('/update-status', [OrderController::class, 'updateStatus'])->name('update.status');
        Route::get('/orders', [OrderController::class, 'index'])->name('dashboard.orders.index');
        Route::controller(AnalyticsController::class)->group(function () {
            Route::get('/sales', 'predictSales')->name('analytics.sales');
            Route::get('/recommendations/{customer_id}', 'recommendProducts')->name('analytics.recommendations');
            Route::get('/report', 'exportPDF')->name('sales.report.download');
        });
        Route::controller(CommentController::class)->group(function () {
            Route::get('/comments', 'index')->name('comments.index');
            Route::patch('/comment/{id}/publish', 'publish')->name('comment.publish');
            Route::delete('/comment/{id}', 'destroy')->name('comment.destroy');
            Route::patch('/comment/{id}/restore', 'restore')->name('comment.restore');
            Route::patch('/comment/{id}/pending', 'setToPending')->name('comment.pending');
        });
    });
});


Route::get('/customer/{id}/points', [CustomerController::class, 'showPoints']);
