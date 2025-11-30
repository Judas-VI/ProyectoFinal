<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Stock;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Agregar un stock al carrito y se actualiza 
     */
    public function agregar(Request $request, Carrito $carrito)
    {
        $data = $request->validate([
            'stock_id' => 'required|integer|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'nullable|numeric',
        ]);

        try {
            $this->adjuntarStockAlCarrito($carrito, $data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        // Redirigir a la vista del carrit
        return redirect()->route('carrito.show', $carrito)->with('success', 'Producto agregado al carrito.');
    }

    
    /// Agregar producto al carrito del usuario autenticado (crea carrito si no existe)
     
    public function agregarAlUsuario(Request $request)
    {
        $data = $request->validate([
            'stock_id' => 'required|integer|exists:stocks,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'nullable|numeric',
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
            // No hay usuario autenticado: usar carrito de invitado en sesión
            $stock = Stock::find($data['stock_id']);
            if (! $stock) {
                return back()->withErrors(['stock' => 'Stock no encontrado.']);
            }

            if ($stock->stock < $data['cantidad']) {
                return back()->withErrors(['cantidad' => 'No hay suficiente stock disponible.']);
            }

            $precio = $data['precio'] ?? $stock->precio;

            $guestCart = session()->get('guest_carrito', []);

            DB::beginTransaction();
            try {
                // decrementar stock en DB
                $stock->stock = $stock->stock - $data['cantidad'];
                $stock->save();

                $encontrado = false;
                foreach ($guestCart as &$item) {
                    if ($item['stock_id'] == $stock->id) {
                        $item['cantidad'] = $item['cantidad'] + $data['cantidad'];
                        $item['precio'] = $precio;
                        $encontrado = true;
                        break;
                    }
                }
                if (! $encontrado) {
                    $guestCart[] = [
                        'stock_id' => $stock->id,
                        'cantidad' => $data['cantidad'],
                        'precio' => $precio,
                    ];
                }

                session()->put('guest_carrito', $guestCart);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'No se pudo agregar al carrito: ' . $e->getMessage()]);
            }

            return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito (invitado).');
        }

        $carrito = Carrito::where('usuario_id', $resolvedUsuarioId)->latest()->first();
        if (! $carrito) {
            $carrito = Carrito::create([
                'usuario_id' => $resolvedUsuarioId,
                'total_precio' => 0,
                'fecha_pedido' => now()->toDateString(),
            ]);
        }

        try {
            $this->adjuntarStockAlCarrito($carrito, $data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito del usuario.');
    }

    /**
     * Agregar producto al carrito
     */
    // Guest-cart functionality removed: users must be authenticated to use cart features.

    /**
     * Método reutilizable que adjunta un stock al carrito y recalcula el total.
     */
    private function adjuntarStockAlCarrito(Carrito $carrito, array $data)
    {
        $stock = Stock::find($data['stock_id']);
        if (! $stock) {
            throw new \Exception('Stock no encontrado.');
        }
        $precio = $data['precio'] ?? $stock->precio;

        DB::beginTransaction();
        try {
            if ($stock->stock < $data['cantidad']) {
                throw new \Exception('No hay suficiente stock disponible.');
            }

            $existing = $carrito->stocks()->where('stocks.id', $stock->id)->first();

            if ($existing) {
                // incrementar pivot y decrementar stock por la diferencia
                $newCantidad = $existing->pivot->cantidad + $data['cantidad'];
                $carrito->stocks()->updateExistingPivot($stock->id, ['cantidad' => $newCantidad, 'precio' => $precio]);
                $stock->stock = $stock->stock - $data['cantidad'];
                $stock->save();
            } else {
                $carrito->stocks()->attach($stock->id, ['cantidad' => $data['cantidad'], 'precio' => $precio]);
                $stock->stock = $stock->stock - $data['cantidad'];
                $stock->save();
            }

            $total = 0;
            foreach ($carrito->stocks()->get() as $s) {
                $total += $s->pivot->precio * $s->pivot->cantidad;
            }
            $carrito->total_precio = $total;
            $carrito->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrito $carrito)
    {
        DB::beginTransaction();
        try {
            
            foreach ($carrito->stocks()->get() as $s) {
                $stock = Stock::find($s->id);
                if ($stock) {
                    $stock->stock = $stock->stock + ($s->pivot->cantidad ?? 0);
                    $stock->save();
                }
            }

            $carrito->stocks()->detach();
            $carrito->delete();

            DB::commit();
            return back()->with('success','Carrito eliminado');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'No se pudo eliminar el carrito: ' . $e->getMessage()]);
        }
    }
}
