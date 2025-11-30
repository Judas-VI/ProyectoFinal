<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table ='stocks';
    protected $fillable = [
            'precio',
            'nombre_stock',
            'fecha_creacion',
            'descripcion',
            'stock',
            'img',
    ];

    public function carritos()
    {
        return $this->belongsToMany(\App\Models\Carrito::class, 'pivote_stock_carritos')
                    ->withPivot(['precio', 'cantidad'])
                    ->withTimestamps();//no me acuerdo si lo usamos o no xd
    }
}
