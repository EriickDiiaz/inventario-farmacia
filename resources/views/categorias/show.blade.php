@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $categoria->nombre }}</h1>
    <p><strong>Descripción:</strong> {{ $categoria->descripcion ?? 'Sin descripción' }}</p>

    @auth
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-outline-primary">Editar</a>
        <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Eliminar</button>
        </form>
    @endauth

    <hr>
    <h3>Productos de esta categoría</h3>
    <div class="row">
        @forelse($categoria->productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('productos.show', $producto) }}" class="text-decoration-none">{{ $producto->nombre }}</a>
                        </h5>
                        <p class="card-text">{{ $producto->descripcion ?? 'Sin descripción' }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
                        <p class="card-text"><strong>Stock:</strong> {{ $producto->stock }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No hay productos asociados a esta categoría.</p>
            </div>
        @endforelse
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
