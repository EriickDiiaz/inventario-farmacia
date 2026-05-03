@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth
                        <h4>Bienvenido, {{ Auth::user()->name }}!</h4>
                        <p>Estás logueado en el sistema de inventario de la farmacia.</p>
                    @else
                        <h4>Bienvenido al inventario de la farmacia</h4>
                        <p>Explora las categorías y productos disponibles. Inicia sesión para agregar, editar o eliminar registros.</p>
                        <a href="{{ route('login') }}" class="btn btn-outlne-primary mb-3">Iniciar Sesión</a>
                    @endauth

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5>Total de Categorías</h5>
                                    <h2>{{ $totalCategorias }}</h2>
                                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-primary">Ver Categorías</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5>Total de Productos</h5>
                                    <h2>{{ $totalProductos }}</h2>
                                    <a href="{{ route('productos.index') }}" class="btn btn-outline-primary">Ver Productos</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Productos Recientes</h5>
                        @if($productosRecientes->count() > 0)
                            <ul class="list-group">
                                @foreach($productosRecientes as $producto)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $producto->nombre }}</strong> - ${{ $producto->precio }} (Stock: {{ $producto->stock }})
                                            <br><small class="text-muted">Categoría: {{ $producto->categoria->nombre }}</small>
                                        </div>
                                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-outline-info">Ver</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No hay productos registrados aún.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
