<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
	->middleware('guest')
	->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
	->middleware('guest')
	->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
	->middleware('guest')
	->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
	->middleware('guest')
	->name('password.update');

//Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//	->middleware(['auth', 'signed', 'throttle:6,1'])
//	->name('verification.verify');

Route::get('/verify-email', [VerifyEmailController::class, 'validateHash']);

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
	->middleware(['auth', 'throttle:6,1'])
	->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
	//->middleware('auth')
	->name('logout');

Route::get('/jolly-user', function (Request $request) {
	return $request->session()->get('user', null);
});

Route::post('/add-funds', [PaymentController::class, 'store']);

Route::get('/payment/gateways', [PaymentController::class, 'index']);
Route::post('/payment/gateways/new', [PaymentController::class, 'storeGateway']);
Route::delete('/payment/gateways/{id}', [PaymentController::class, 'deleteGateway']);

Route::get('/user/limit', [PaymentController::class, 'getUserLimit']);
Route::post('/user/limit/update', [PaymentController::class, 'updateUserLimit']);

Route::post('/lotteries/checkout', [CheckoutController::class, 'storeShoppingCart']);

// Profile update.
Route::post('/update', [AuthenticatedSessionController::class, 'update'])
	->name('update');
