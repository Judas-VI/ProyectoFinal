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
        return view('carrito.index', compact('carritos'));
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

        // Resolve usuario_id: prefer matching Usuario record for the authenticated user
        $resolvedUsuarioId = null;
        if ($user = Auth::user()) {
            $usuario = Usuario::where('email', $user->email)->first();
            if ($usuario) {
                $resolvedUsuarioId = $usuario->id;
            } elseif (Usuario::find($user->id)) {
                $resolvedUsuarioId = $user->id;
            }
        }

        // If no Usuario matched the authenticated user, allow explicit usuario_id from request
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
        //
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
     * Remove the specified resource from storage.
     */
    public function destroy(Carrito $carrito)
    {
        $carrito->stocks()->detach();
        $carrito->delete();
        return back()->with('success','Carrito eliminado');
    }
}
