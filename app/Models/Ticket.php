<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'receptor', 'emisor', 'nacimiento', 'color', 'excepcion' , 'pyme', 'foto' , 'mensaje' , 'entrega' , 'direccion' , 'telefono' , 'estado', 'tipo' ,
    ];

    public function getEstado()
    {
        return $this->belongsTo(Estado::class, 'estado');
    }   

    public function getTipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo');
    }  
}
