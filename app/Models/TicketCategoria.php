<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','categoria',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getCategoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria');
    }
}
