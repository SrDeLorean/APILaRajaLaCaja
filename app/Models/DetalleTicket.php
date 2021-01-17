<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket', 'producto', 'cantidad', 'precio', 'total'
    ];

    /**
     * esto tiene que hacer referencia a la tabla intermedia, no la final, son id diferentes
     */
    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }

    public function getProducto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }  

}
