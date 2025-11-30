<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarioId = null;
        if ($user = Auth::user()) {
            $usuario = Usuario::where('email', $user->email)->first();
            if ($usuario) {
                $usuarioId = $usuario->id;
            } elseif (Usuario::find($user->id)) {
                $usuarioId = $user->id;
            }
        }
        $carritos = $usuarioId ? Carrito::where('usuario_id', $usuarioId)->with('stocks')->get() : collect();
        return view('carrito.carrito-index', compact('carritos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'total_precio' => 'required|numeric',
            'fecha_pedido' => 'required|date',
            'usuario_id' => 'sometimes|integer',
        ]);

        $resolvedUsuarioId = null;
        if ($user = Auth::user()) {
            $usuario = Usuario::where('email', $user->email)->first();
            if ($usuario) {
                $resolvedUsuarioId = $usuario->id;
            } elseif (Usuario::find($user->id)) {
                $resolvedUsuarioId = $user->id;
            }
        }

        
        if (! $resolvedUsuarioId) {
            if (! empty($data['usuario_id'])) {
                $exists = Usuario::where('id', $data['usuario_id'])->exists();
                if (! $exists) {
                    return back()->withErrors(['usuario_id' => 'El usuario especificado no existe en la tabla usuarios.']);
                }
                $resolvedUsuarioId = $data['usuario_id'];
            } else {
                return back()->withErrors(['usuario_id' => 'No se encontró un registro en tabla usuarios para el usuario autenticado; proporcione usuario_id.']);
            }
        }

        $data['usuario_id'] = $resolvedUsuarioId;
        $carrito = Carrito::create($data);
        return redirect()->route('carrito.show', $carrito)->with('success', 'Carrito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carrito $carrito)
    {
        return view('carrito.carrito-check', compact('carrito'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrito $carrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Carrito $carrito)
    {
        $data = $request->validate([
            'total_precio' => 'required|numeric',
            'fecha_pedido' => 'sometimes|date',
        ]);
        $carrito->update($data);
        return redirect()->route('carrito.show', $carrito)->with('success', 'Carrito actualizado exitosamente.');
    }

    /**
     * Agregar un stock al carrito y se actualiza si existe
     */
    public function agregar(Request $request, Carrito $carrito)
    {
        $data = $request->validate([
            'stock_id' => 'required|integer|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'nullable|numeric',
        ]);

        $stock = \App\Models\Stock::find($data['stock_id']);
        if (! $stock) {
            return back()->withErrors(['stock_id' => 'Producto no encontrado.']);
        }

        if ($stock->stock < $data['cantidad']) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible.']);
        }

        $precio = $data['precio'] ?? $stock->precio;

        $existing = $carrito->stocks()->where('stocks.id', $stock->id)->first();

        if ($existing) {
            $newCantidad = $existing->pivot->cantidad + $data['cantidad'];
            $carrito->stocks()->updateExistingPivot($stock->id, ['cantidad' => $newCantidad, 'precio' => $precio]);
        } else {
            $carrito->stocks()->attach($stock->id, ['cantidad' => $data['cantidad'], 'precio' => $precio]);
        }

        //poner el precio
        $total = 0;
        foreach ($carrito->stocks()->get() as $s) {
            $total += $s->pivot->precio * $s->pivot->cantidad;
        }
        $carrito->total_precio = $total;
        $carrito->save();

        return back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrito $carrito)
    {
        $carrito->stocks()->detach();
        $carrito->delete();
        return back()->with('success','Carrito eliminado');
    }
}
