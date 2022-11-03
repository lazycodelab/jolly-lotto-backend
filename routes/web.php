<?php

use App\Http\Controllers\ProductController;
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

Route::get('/lotteries/{product}/fetch', [ProductController::class, 'fetchDetails']);
Route::get('/lotteries', [ProductController::class, 'index']);
Route::get('/lotteries/{product}', [ProductController::class, 'show']);

require __DIR__.'/auth.php';
