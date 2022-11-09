<?php

use App\Http\Controllers\LotteryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Temp routes.
Route::get('/fetchDet', [ProductController::class, 'binChilling']);
Route::get('/lotteries/fetch', [ProductController::class, 'fetch']);

Route::get('/lotteries/{product}/fetchDetails', [ProductController::class, 'fetchDetails']);
Route::get('/lotteries/{lottery}/fetchResults', [ResultController::class, 'fetchResults']);

Route::get('/lotteries', [ProductController::class, 'index']);
Route::get('/lotteries/{product}', [ProductController::class, 'show']);
Route::get('/lotteries/{lottery}/results', [LotteryController::class, 'results']);

require __DIR__.'/auth.php';
