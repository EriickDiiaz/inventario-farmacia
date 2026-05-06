<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// Rutas protegidas para CRUD completo
Route::middleware('auth')->group(function () {
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
    Route::resource('usuarios', UserController::class);
});

// Rutas públicas para ver
Route::resource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::resource('productos', ProductoController::class)->only(['index', 'show']);



Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
