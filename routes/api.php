<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MarkController;
use App\Http\Controllers\User\CountryController;

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

Route::prefix('auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('marks', MarkController::class);

Route::get('countries', CountryController::class);

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('profile')->group(function (){
        Route::get('', [ProfileController::class, 'me']);
        Route::post('logout', [ProfileController::class, 'logout']);
    });
});
