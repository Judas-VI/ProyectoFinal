<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Livewire\Volt\Exceptions\ReturnNewClassExecutionEndingException;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::orderBy('nombre_stock')->get(); 
        return view('viewStock.index-stock', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('viewStock.crear-stock');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'precio' => 'required|numeric|min:0',
            'nombre_stock' => 'required|string|max:20',
            'fecha_creacion' => 'required|date',
            'descripcion' => 'required|string|max:200',
            'stock' => 'required|integer|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('stocks', 'public');
            $validated['img'] = $imagePath;
        }
        Stock::create($validated);
        return redirect()->route('stock.index')->with('success', 'Producto de stock creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return view('viewStock.show-stock')->with(['stock' => $stock]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return view('')->with(['stock' => $stock]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $stock->update($request->all());

        return redirect()->route('', $stock->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
