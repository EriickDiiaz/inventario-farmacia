@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6 d-flex align-items-center">
        <h1>Productos</h1>
        <span class="badge bg-primary ms-2">{{ $productos->count() }}</span>
    </div>
   
    <div class="row align-items-center mb-3">
        <div class="d-flex align-items-center justify-content-between">
            @auth
                <a href="{{ route('productos.create') }}" class="btn btn-outline-primary mb-3">Crear Producto</a>
            @endauth
            <form action="{{ route('productos.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar productos..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>
    </div>
    
    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height:180px; object-fit:cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->precio ?? 'N/D' }}</p>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-outline-info">Ver</a>
                        @auth
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-primary">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
