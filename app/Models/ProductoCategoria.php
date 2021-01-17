<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCategoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto','categoria',
    ];

    /**
     * esto tiene que hacer referencia a la tabla intermedia, no la final, son id diferentes
     */
    public function getProducto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }  

    public function getCategoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria');
    }
}
