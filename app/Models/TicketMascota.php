<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','mascota',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getMascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota');
    }
}
