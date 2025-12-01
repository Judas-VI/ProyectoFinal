<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;


class Pago extends Model
{
    use SoftDeletes;

    protected $table = 'pagos';
    public $timestamps = false; 
    protected $fillable = ['carrito_id','fecha_pago','monto'];
}
