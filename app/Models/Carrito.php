<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrito extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'carritos';

    protected $fillable = [
        'usuario_id',
        'total_precio',
        'fecha_pedido',
    ];
    
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }
    
    public function stocks()
    {
        return $this->belongsToMany(\App\Models\Stock::class, 'pivote_stock_carritos')
                    ->withPivot(['precio', 'cantidad'])
                    ->withTimestamps();
    }

    public function pagos()
    {
       return $this->hasMany(\App\Models\Pago::class, 'carrito_id');
    } 
    
    
}
    