<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('users', [AuthController::class, 'users']);
    Route::put('toAdmin/{id}', [AuthController::class, 'userToAdmin']);
    Route::put('toUser/{id}', [AuthController::class, 'adminToUser']);
    Route::post('forgot/{email}', [AuthController::class, 'forgotPassword']);
});

Route::prefix('menus')->group(function () {
    Route::get('all', [ProductController::class, 'index']);
    Route::post('menu', [ProductController::class, 'create']);
    Route::delete('menu/{id}', [ProductController::class, 'destroy']);
    Route::get('menu/{id}', [ProductController::class, 'show']);
});

Route::prefix('checkout')->group(function () {
    Route::get('get/{id}', [CheckoutController::class, 'index']);
    Route::get('show/{id}', [CheckoutController::class, 'show']);
    Route::post('add/{user_id}/{code}', [CheckoutController::class, 'create']);
    Route::delete('delete/{id}', [CheckoutController::class, 'destroy']);
});

Route::prefix('purchase')->group(function () {
    Route::get('get/admin', [PurchaseController::class, 'getPurchaseAdmin']);
    Route::get('get/{id}', [PurchaseController::class, 'index']);
    Route::get('show/{id}', [PurchaseController::class, 'show']);
    Route::put('delivered/{id}', [PurchaseController::class, 'delivered']);
    Route::post('payment/{user_id}/{id}', [PurchaseController::class, 'payment']);
    Route::post('create/{user_id}', [PurchaseController::class, 'create']);
    Route::delete('delete/{id}', [PurchaseController::class, 'destroy']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
