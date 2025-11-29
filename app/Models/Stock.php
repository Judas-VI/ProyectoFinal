<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table ='stocks';
    protected $fillable = [
            'precio',
            'nombre_stock',
            'fecha_creacion',
            'descripcion',
            'stock',
            'img',
    ];
}
