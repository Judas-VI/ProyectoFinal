<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pivote_stock_carrito extends Model
{
    protected $table = 'pivote_stock_carritos';

    protected $fillable = [
        'carrito_id',
        'stock_id',
        'precio',
        'cantidad',
    ];

    public function carrito()
    {
        return $this->belongsTo(\App\Models\Carrito::class, 'carrito_id');
    }

    public function stock()
    {
        return $this->belongsTo(\App\Models\Stock::class, 'stock_id');
    }
}
