@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6 d-flex align-items-center">
        <h1>Movimientos de Inventario</h1>
        <span class="badge bg-primary ms-2">{{ $movimientos->total() }}</span>
    </div>
   
    <div class="row align-items-center mb-3">
        <div class="d-flex align-items-center justify-content-between">
            @auth
                <a href="{{ route('movimientos.create') }}" class="btn btn-outline-primary mb-3">Registrar Movimiento</a>
            @endauth
            <form action="{{ route('movimientos.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar movimientos..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">Buscar</button>
            </form>
        </div>
    </div>

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