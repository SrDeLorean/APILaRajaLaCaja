<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPreferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto','preferencia',
    ];

    /**
     * esto tiene que hacer referencia a la tabla intermedia, no la final, son id diferentes
     */
    public function getProducto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }  

    public function getPreferencia()
    {
        return $this->belongsTo(Preferencia::class, 'preferencia');
    }
}
