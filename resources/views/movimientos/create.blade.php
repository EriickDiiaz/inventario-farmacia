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
    <h1>Registrar Movimiento</h1>
    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="producto_id" class="form-label">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control" required>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }} (Stock: {{ $producto->stock }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="precio_unitario" class="form-label">Precio unitario (opcional)</label>
            <input type="number" step="0.01" name="precio_unitario" id="precio_unitario" class="form-control">
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <input type="text" name="motivo" id="motivo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="referencia" class="form-label">Referencia</label>
            <input type="text" name="referencia" id="referencia" class="form-control">
        </div>

        <button class="btn btn-outline-primary">Registrar</button>
        <a href="{{ route('movimientos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </form>
</div>
@endsection