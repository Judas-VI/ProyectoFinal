<?php

namespace App\Http\Controllers;

use App\Models\Pivote_stock_carrito;
use Illuminate\Http\Request;

class PivoteStockCarritoController extends Controller
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
     * Display the specified resource.
     */
    public function show(Pivote_stock_carrito $pivote_stock_carrito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pivote_stock_carrito $pivote_stock_carrito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pivote_stock_carrito $pivote_stock_carrito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pivote_stock_carrito $pivote_stock_carrito)
    {
        // Eliminar la fila  que relaciona un stock con un carrito por id  
        try {
            $pivote_stock_carrito->delete();
            return back()->with('success', 'Producto eliminado del carrito.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No se pudo eliminar el producto del carrito.']);
        }
    }
}
