<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    return view('admin');
});