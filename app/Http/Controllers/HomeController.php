<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCategorias = Categoria::count();
        $totalProductos = Producto::count();
        $productosRecientes = Producto::with('categoria')->latest()->take(5)->get();

        return view('home', compact('totalCategorias', 'totalProductos', 'productosRecientes'));
    }
}
