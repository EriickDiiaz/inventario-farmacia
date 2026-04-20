@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $categoria->name }}</h1>
    <p><strong>Descripción:</strong> {{ $categoria->description ?? 'Sin descripción' }}</p>
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Volver</a>
    @auth
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
    @endauth
</div>
@endsection
