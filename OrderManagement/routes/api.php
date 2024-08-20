<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/token/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);
});


Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->middleware('auth');
    Route::get('{id}', [CategoryController::class, 'show'])->middleware('auth');
    Route::post('/', [CategoryController::class, 'store'])->middleware('is_admin');
    Route::put('{id}', [CategoryController::class, 'update'])->middleware('is_admin');
    Route::delete('{id}', [CategoryController::class, 'destroy'])->middleware('is_admin');
});
Route::prefix('products')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->middleware('auth');
        Route::get('{id}', 'show')->middleware('auth');
        Route::post('/', 'store')->middleware('is_admin');
        Route::put('{id}', 'update')->middleware('is_admin');
        Route::delete('{id}', 'destroy')->middleware('is_admin');
    });
});
