<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {
    Route::name('dashboard.')->prefix('dashboard')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::middleware(['admin'])->group(function() {
            Route::resource('category', ProductCategoryController::class);
            Route::resource('product', ProductController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::resource('transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            Route::resource('user', UserController::class)->only([
                'index', 'edit', 'update', 'destroy'
            ]);
        });
    });
});