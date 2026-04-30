@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Categoría</h1>
    <form action="{{ route('categorias.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-outline-primary">Crear</button>
        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
@endsection
