<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\MarkController;
use App\Http\Controllers\User\CountryController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\PostController;

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

Route::prefix('posts')->group(function (){
    Route::get('', [PostController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/favorites', [FavoriteController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/{id}/favorite', [FavoriteController::class, 'store'])->middleware('auth:sanctum');
    Route::delete('/{id}/favorite', [FavoriteController::class, 'destroy'])->middleware('auth:sanctum');
    Route::post('', [PostController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{id}', [PostController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [PostController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('profile')->group(function (){
        Route::get('', [ProfileController::class, 'me']);
        Route::post('logout', [ProfileController::class, 'logout']);
    });
});
