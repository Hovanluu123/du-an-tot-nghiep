<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/email/resend', [AuthController::class, 'resend']);
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware('signed')->name('verification.verify');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // Payment routes
    Route::post('/orders', [PaymentController::class, 'createOrder']);
    Route::get('/orders', [PaymentController::class, 'getOrders']);
    Route::get('/orders/{id}', [PaymentController::class, 'getOrder']);
    Route::patch('/orders/{id}/status', [PaymentController::class, 'updateOrderStatus']);
    Route::patch('/payments/{id}/status', [PaymentController::class, 'updatePaymentStatus']);
});

// VNPAY callback (không cần auth)
Route::get('/payment/vnpay/callback', [PaymentController::class, 'vnpayCallback']);


