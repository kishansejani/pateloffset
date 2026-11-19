<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Storefront
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/category/{category}', [ShopController::class, 'category'])->name('category');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('product');
Route::post('/product/{product}/review', [ShopController::class, 'review'])->middleware('throttle:5,1')->name('product.review');

// Cart & checkout
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{number}', [CheckoutController::class, 'payment'])->name('payment');
Route::post('/payment/verify', [CheckoutController::class, 'verify'])->name('payment.verify');
Route::get('/payment/{number}/failed', [CheckoutController::class, 'failed'])->name('payment.failed');
Route::get('/order/{number}/success', [CheckoutController::class, 'success'])->name('order.success');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/request-quote', [PageController::class, 'quote'])->name('quote');
Route::post('/inquiry', [PageController::class, 'inquiry'])->middleware('throttle:10,1')->name('inquiry');
Route::post('/subscribe', [PageController::class, 'subscribe'])->middleware('throttle:10,1')->name('subscribe');
Route::get('/track-order', [PageController::class, 'track'])->name('track');
Route::get('/policy/{page}', [PageController::class, 'policy'])->name('policy');

// Admin panel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'show'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');
        Route::get('inquiries', [Admin\InquiryController::class, 'index'])->name('inquiries.index');
        Route::patch('inquiries/{inquiry}', [Admin\InquiryController::class, 'toggle'])->name('inquiries.toggle');
        Route::delete('inquiries/{inquiry}', [Admin\InquiryController::class, 'destroy'])->name('inquiries.destroy');
        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::resource('categories', Admin\CategoryController::class)->except('show');
    });
});
