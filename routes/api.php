<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

// Login tanpa token
Route::post('/login', [AuthController::class, 'login']);

// Route yang wajib menggunakan token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

// CRUD buku
Route::apiResource('books', BookController::class);
