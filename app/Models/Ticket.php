<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'receptor', 'emisor', 'edad', 'nacimiento', 'color', 'excepcion' , 'pyme', 'foto' , 'mensaje' , 'entrega', 'region', 'comuna' , 'direccion' , 'telefono' , 'estado', 'tipoCaja', 'tipoPersona' ,' motivo', 'cantidadProductos', 'precioCompra', 'precioVenta'
    ];

    public function getMotivo()
    {
        return $this->belongsTo(Motivo::class, 'motivo');
    }   

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'estado');
    }   

    public function getTipoCaja()
    {
        return $this->belongsTo(TipoCaja::class, 'tipoCaja');
    }  
}
