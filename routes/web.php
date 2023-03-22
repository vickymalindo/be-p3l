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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::prefix('menus')->group(function () {
//     Route::get('all', [ProductController::class, 'index']);
//     Route::post('menu', [ProductController::class, 'create']);
//     Route::delete('menu/{id}', [ProductController::class, 'destroy']);
//     Route::get('menu/{id}', [ProductController::class, 'show']);
// });