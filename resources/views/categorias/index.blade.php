@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6 d-flex align-items-center">
        <h1>Categorías</h1>
        <span class="badge bg-primary ms-2">{{ $categorias->count() }}</span>
    </div>
   
    <div class="row align-items-center mb-3">
        <div class="d-flex align-items-center justify-content-between">
            @auth
                <a href="{{ route('categorias.create') }}" class="btn btn-outline-primary mb-3">Crear Categoría</a>
            @endauth
            <form action="{{ route('categorias.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar categorías..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>
    </div>

    <div class="row">
        @foreach($categorias as $categoria)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title">{{ $categoria->nombre }}</h5>
                            <span class="badge bg-primary m-2">{{ $categoria->productos->count() }}</span>
                        </div>
                        <p class="card-text">{{ $categoria->descripcion ?? 'Sin descripción' }}</p>
                        <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-outline-info">Ver</a>
                        @auth
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-outline-primary">Editar</a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline delete-form">
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
// Toast auto-hide
document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('successToast');
    if (toastEl) {
        setTimeout(function () {
            var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.hide();
        }, 3500); // 3.5 segundos
    }

    // Confirmación SweetAlert para eliminar
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
