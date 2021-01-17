<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPasaTiempo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','pasaTiempo',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getPasaTiempo()
    {
        return $this->belongsTo(PasaTiempo::class, 'pasaTiempo');
    }
}
