<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPasatiempo extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto','pasatiempo',
    ];

    /**
     * esto tiene que hacer referencia a la tabla intermedia, no la final, son id diferentes
     */
    public function getProducto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }  

    public function getPasatiempo()
    {
        return $this->belongsTo(Pasatiempo::class, 'pasatiempo');
    }
}
