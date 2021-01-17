<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPreferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','preferencia',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getPreferencia()
    {
        return $this->belongsTo(Preferencia::class, 'preferencia');
    }
}
