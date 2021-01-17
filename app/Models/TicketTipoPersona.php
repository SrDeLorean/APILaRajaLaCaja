<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTipoPersona extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','tipoPersona',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getTipoPersona()
    {
        return $this->belongsTo(TipoPersona::class, 'tipoPersona');
    }
}
