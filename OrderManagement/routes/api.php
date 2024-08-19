<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'category'], function ($router){
    Route::controller(CategoryController::class)->group(function (){
        Route::get('index','index');
        Route::get('show/{id}','show');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('destroy/{id}','destroy');
    });
});
Route::group(['prefix'=>'product'], function ($router){
    Route::controller(ProductController::class)->group(function (){
        Route::get('index','index');
        Route::get('show/{id}','show');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('destroy/{id}','destroy');
    });
});
