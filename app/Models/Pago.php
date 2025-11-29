<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;


class Pago extends Model
{
    protected $table = 'pagos';
    public $timestamps = false; 
    protected $fillable = ['carrito_id','fecha_pago','monto'];
}
