@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Movimiento #{{ $movimiento->id }}</h1>

    <p><strong>Producto:</strong> {{ $movimiento->producto->nombre }}</p>
    <p><strong>Tipo:</strong> {{ ucfirst($movimiento->tipo) }}</p>
    <p><strong>Cantidad:</strong> {{ $movimiento->cantidad }}</p>
    <p><strong>Usuario:</strong> {{ $movimiento->usuario->name ?? 'Sistema' }}</p>
    <p><strong>Motivo:</strong> {{ $movimiento->motivo ?? '-' }}</p>
    <p><strong>Referencia:</strong> {{ $movimiento->referencia ?? '-' }}</p>
    <p><strong>Registrado:</strong> {{ $movimiento->created_at->format('d/m/Y H:i') }}</p>

    <a href="{{ route('movimientos.index') }}" class="btn btn-outline-secondary">Volver</a>
    @auth
        <a href="{{ route('movimientos.edit', $movimiento) }}" class="btn btn-outline-primary">Editar</a>
    @endauth
</div>
@endsection