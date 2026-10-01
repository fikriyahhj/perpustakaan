<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;

Route::resource('products', ProductController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin', function () {
    $products = \App\Models\Product::all();

    return view('admin', compact('products'));
});

Route::get('/kasir', function () {
    $products = \App\Models\Product::all();

    return view('kasir', compact('products'));
});