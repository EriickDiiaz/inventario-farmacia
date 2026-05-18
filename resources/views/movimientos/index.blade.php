@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div aria-live="polite" aria-atomic="true" class="position-fixed top-0 end-0 p-3" style="z-index: 1080; min-width: 300px;">
        <div class="toast align-items-center text-bg-warning border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="warningToast">
            <div class="d-flex">
                <div class="toast-body">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
<div class="container">
    <div class="d-flex align-items-center">
        <h1>Movimientos de Inventario</h1>
        <span class="badge bg-primary m-2">{{ $movimientos->count() }}</span>
    </div>
    @auth
    <a href="{{ route('movimientos.create') }}" class="btn btn-outline-primary mb-3">Registrar Movimiento</a>
    @endauth

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->id }}</td>
                    <td>{{ $movimiento->producto->nombre }}</td>
                    <td>{{ ucfirst($movimiento->tipo) }}</td>
                    <td>{{ $movimiento->cantidad }}</td>
                    <td>{{ $movimiento->usuario->name ?? 'Sistema' }}</td>
                    <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('movimientos.show', $movimiento) }}" class="btn btn-outline-info">Ver</a>
                        @auth
                        <a href="{{ route('movimientos.edit', $movimiento) }}" class="btn btn-outline-primary">Editar</a>
                        <form action="{{ route('movimientos.destroy', $movimiento) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger">Eliminar</button>
                        </form>
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $movimientos->links() }}
</div>

<script>
function confirmDelete() {
    return Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción revertirá el movimiento en el stock.",
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