<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;

// Public routes

Route::get('posts', [PostController::class, 'index']); //OK
Route::get('posts/{post}', [PostController::class, 'show']); //OK

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::get('user', [AuthController::class, 'user']);
    Route::put('user', [AuthController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::delete('user', [AuthController::class, 'destroy']);
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);
});
