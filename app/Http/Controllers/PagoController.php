<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Carrito;
use App\Models\Stock;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Genera un PDF tipo ticket con los items del carrito (usuario o invitado).
     */
    public function generarPdf(Request $request)
    {
        $items = [];

        // Resolver carrito del usuario autenticado
        $resolvedUsuarioId = null;
        if ($user = Auth::user()) {
            $usuario = Usuario::where('email', $user->email)->first();
            if ($usuario) {
                $resolvedUsuarioId = $usuario->id;
            } elseif (Usuario::find($user->id)) {
                $resolvedUsuarioId = $user->id;
            }
        }

        if ($resolvedUsuarioId) {
            $carrito = Carrito::where('usuario_id', $resolvedUsuarioId)->latest()->first();
            if ($carrito) {
                foreach ($carrito->stocks()->get() as $s) {
                    $items[] = [
                        'name' => $s->nombre ?? $s->descripcion ?? ('Item ' . $s->id),
                        'qty' => $s->pivot->cantidad ?? 1,
                        'price' => (float) ($s->pivot->precio ?? $s->precio ?? 0),
                    ];
                }
            }
        } else {
            // carrito de invitado en sesión
            $guest = session()->get('guest_carrito', []);
            foreach ($guest as $g) {
                $stock = Stock::find($g['stock_id']);
                $items[] = [
                    'name' => $stock->nombre ?? $stock->descripcion ?? ('Item ' . ($stock->id ?? '')), 
                    'qty' => $g['cantidad'] ?? 1,
                    'price' => (float) ($g['precio'] ?? ($stock->precio ?? 0)),
                ];
            }
        }

        // Si no hay items, usar ejemplo para pruebas
        if (empty($items)) {
            $items = [
                ['name' => 'Item de prueba A', 'qty' => 1, 'price' => 100.00],
                ['name' => 'Item de prueba B', 'qty' => 2, 'price' => 50.00],
            ];
        }

        $pdf = Pdf::loadView('PDF.pdf', [
            'items' => $items,
            'orderId' => 'TCK-' . Str::upper(Str::random(6)),
            'date' => now()->format('d/m/Y H:i'),
            'storeName' => config('app.name', 'Mi Tienda'),
            'storeAddress' => '',
            'storePhone' => '',
            'tax' => 0,
        ]);

        return $pdf->stream('ticket.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pago $pago)
    {
        //
    }
}
