<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Route::resource('products', ProductController::class);

// Route::get('/innerjoin', [ProductController::class, 'innerjoin']);
// Route::get('/leftjoin', [ProductController::class, 'leftjoin']);
// Route::get('/rightjoin', [ProductController::class, 'rightjoin']);
// Route::get('/crossjoin', [ProductController::class, 'crossjoin']);
// Route::get('/advancedjoin', [ProductController::class, 'advancedjoin']);
