<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas para ver
Route::resource('categorias', CategoriaController::class)->only(['index', 'show']);
Route::resource('productos', ProductoController::class)->only(['index', 'show']);

// Rutas protegidas para CRUD completo
Route::middleware('auth')->group(function () {
    Route::resource('categorias', CategoriaController::class)->except(['index', 'show']);
    Route::resource('productos', ProductoController::class)->except(['index', 'show']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
