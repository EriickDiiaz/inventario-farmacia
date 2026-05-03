@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $producto->nombre }}</h1>
    <p><strong>Descripción:</strong> {{ $producto->descripcion ?? 'Sin descripción' }}</p>
    <p><strong>Precio:</strong> ${{ $producto->precio }}</p>
    <p><strong>Stock:</strong> {{ $producto->stock }}</p>
    <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Volver</a>
    @auth
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-primary">Editar</a>
    @endauth
</div>
@endsection
