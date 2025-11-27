<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    public $timestamps = false; // según tu migration
    protected $fillable = ['carrito_id','fecha_pago','monto'];
}