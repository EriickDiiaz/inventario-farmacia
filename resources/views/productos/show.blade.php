@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $producto->name }}</h1>
    <p><strong>Descripción:</strong> {{ $producto->description ?? 'Sin descripción' }}</p>
    <p><strong>Precio:</strong> ${{ $producto->price }}</p>
    <p><strong>Stock:</strong> {{ $producto->stock }}</p>
    <p><strong>Categoría:</strong> {{ $producto->categoria->name }}</p>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
    @auth
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
    @endauth
</div>
@endsection
