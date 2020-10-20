<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user',[\App\Http\Controllers\MainController::class, 'index']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user',[\App\Http\Controllers\MainController::class, 'index']);
    Route::post('/create',[\App\Http\Controllers\MainController::class, 'create']);
    Route::delete('/destroy/{id}',[\App\Http\Controllers\MainController::class, 'delete']);
    Route::put('/change/{id}',[\App\Http\Controllers\MainController::class, 'change']);
});


