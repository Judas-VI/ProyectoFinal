<?php

namespace App\Http\Controllers;

use App\Models\Pivote_stock_carrito;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Eliminar la fila que relaciona un stock con un carrito por id
        DB::beginTransaction();
        try {
            $stock = Stock::find($pivote_stock_carrito->stock_id);
            if ($stock) {
                $stock->stock = $stock->stock + ($pivote_stock_carrito->cantidad ?? 0);
                $stock->save();
            }

            $pivote_stock_carrito->delete();
            DB::commit();
            return back()->with('success', 'Producto eliminado del carrito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'No se pudo eliminar el producto del carrito.']);
        }
    }
}
