<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $movimientos = Movimiento::with('producto', 'usuario')
            ->when($search, function ($query, $search) {
                $query->where('tipo', 'like', "%{$search}%")
                    ->orWhere('motivo', 'like', "%{$search}%")
                    ->orWhere('referencia', 'like', "%{$search}%")
                    ->orWhereHas('producto', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(20);

        return view('movimientos.index', compact('movimientos', 'search'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('movimientos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'precio_unitario' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($data) {
                $data['usuario_id'] = Auth::id();
                $movimiento = Movimiento::create($data);

                $producto = Producto::findOrFail($data['producto_id']);

                if ($data['tipo'] === 'entrada') {
                    $producto->stock = $producto->stock + $data['cantidad'];
                } else {
                    if ($producto->stock < $data['cantidad']) {
                        throw new \Exception('Stock insuficiente para este producto.');
                    }
                    $producto->stock = $producto->stock - $data['cantidad'];
                }

                $producto->save();
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado.');
    }

    public function show($id)
    {
        $movimiento = Movimiento::with('producto', 'usuario')->findOrFail($id);
        return view('movimientos.show', compact('movimiento'));
    }

    public function edit($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        $productos = Producto::all();
        return view('movimientos.edit', compact('movimiento', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $movimiento = Movimiento::findOrFail($id);

        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'precio_unitario' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($movimiento, $data) {
                // revert previous movimiento
                $producto = Producto::findOrFail($movimiento->producto_id);
                if ($movimiento->tipo === 'entrada') {
                    $producto->stock -= $movimiento->cantidad;
                } else {
                    $producto->stock += $movimiento->cantidad;
                }
                $producto->save();

                // apply new movimiento
                $newProducto = Producto::findOrFail($data['producto_id']);
                if ($data['tipo'] === 'entrada') {
                    $newProducto->stock += $data['cantidad'];
                } else {
                    if ($newProducto->stock < $data['cantidad']) {
                        throw new \Exception('Stock insuficiente para este producto.');
                    }
                    $newProducto->stock -= $data['cantidad'];
                }
                $newProducto->save();

                $data['usuario_id'] = Auth::id();
                $movimiento->update($data);
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('movimientos.index')->with('success', 'Movimiento actualizado.');
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::findOrFail($id);

        DB::transaction(function () use ($movimiento) {
            $producto = Producto::findOrFail($movimiento->producto_id);
            // revert effect
            if ($movimiento->tipo === 'entrada') {
                $producto->stock -= $movimiento->cantidad;
                if ($producto->stock < 0) {
                    $producto->stock = 0;
                }
            } else {
                $producto->stock += $movimiento->cantidad;
            }
            $producto->save();

            $movimiento->delete();
        });

        return redirect()->route('movimientos.index')->with('success', 'Movimiento eliminado.');
    }
}
