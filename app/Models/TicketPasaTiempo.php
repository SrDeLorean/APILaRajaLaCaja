<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPasatiempo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','pasatiempo',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getPasatiempo()
    {
        return $this->belongsTo(Pasatiempo::class, 'pasatiempo');
    }
}