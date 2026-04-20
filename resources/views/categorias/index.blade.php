@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categorías</h1>
    @auth
        <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Crear Categoría</a>
    @endauth
    <div class="row">
        @foreach($categorias as $categoria)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $categoria->name }}</h5>
                        <p class="card-text">{{ $categoria->description ?? 'Sin descripción' }}</p>
                        <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-info">Ver</a>
                        @auth
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
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
