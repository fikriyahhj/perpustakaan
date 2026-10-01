<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
<<<<<<< HEAD
=======

route::resource('products', ProductController::class);
>>>>>>> origin/main

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    $products = \App\Models\Product::all();

    return view('admin', compact('products'));
});