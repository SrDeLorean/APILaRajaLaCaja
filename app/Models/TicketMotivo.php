<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMotivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','motivo',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getMotivo()
    {
        return $this->belongsTo(Motivo::class, 'motivo');
    }
}
