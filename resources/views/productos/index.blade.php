@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos</h1>
    @auth
        <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Crear Producto</a>
    @endauth
    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->name }}</h5>
                        <p class="card-text">{{ $producto->description ?? 'Sin descripción' }}</p>
                        <p><strong>Precio:</strong> ${{ $producto->price }}</p>
                        <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                        <p><strong>Categoría:</strong> {{ $producto->categoria->name }}</p>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-info">Ver</a>
                        @auth
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function confirmDelete() {
    return Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        return result.isConfirmed;
    });
}
</script>
@endsection
