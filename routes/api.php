<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;

// Public routes

Route::get('posts', [PostController::class, 'index']); //OK
Route::get('posts/{post}', [PostController::class, 'show']); //OK




Route::post('login', [AuthController::class, 'login']); //OK
Route::post('register', [AuthController::class, 'register']); //OK


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);//OK

    //USERS ROUTES
    Route::put('user', [UserController::class, 'update']); // OK
    Route::delete('user', [UserController::class, 'destroy']); //OK

    //POSTS ROUTES
    Route::post('posts', [PostController::class, 'store']); //OK
    Route::put('posts/{post}', [PostController::class, 'update']);//OK
    Route::delete('posts/{post}', [PostController::class, 'destroy']); //OK

    Route::get('user', [AuthController::class, 'user']);

});
