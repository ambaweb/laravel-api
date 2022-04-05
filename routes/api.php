<?php

use App\Http\Controllers\Api\V1\BuilderController;
use App\Http\Controllers\Api\V1\DivisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['json.response']], function () {
    
    Route::post('/login', [AuthController::class, 'login'])->name('login.api');
    Route::post('/register', [AuthController::class, 'register'])->name('register.api');

    Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['auth:sanctum']], function() {

        Route::resource('builders', BuilderController::class);
        Route::resource('divisions', DivisionController::class);

    });
});
