<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;


Route::resource('products', ProductController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Otomatis mengarahkan ke halaman asal (/kasir) setelah login berhasil
        return redirect()->intended('/kasir');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
})->name('login.post');

Route::get('/admin', function () {
    $products = \App\Models\Product::all();

    return view('admin', compact('products'));
});

Route::get('/kasir', function () {
    
    $products = \App\Models\Product::all();
    return view('kasir', compact('products'));
})->middleware('auth');

Route::get('/invoice/pdf', [InvoiceController::class, 'generate'])
    ->name('invoice.pdf');

Route::post('/orders', [OrderController::class, 'store'])
    ->name('orders.store');