<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('index');
});

Route::get('/product', function () {
    return view('product');
});

Route::get('/checkout', function () {
    return view('checkout');
});

Route::get('/pay', [PaymentController::class, 'handlePayment']);
Route::post('/paynow', [PaymentController::class, 'store'])->name('form.submit');
