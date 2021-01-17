<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBrindi extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket','brindi',
    ];

    public function getTicket()
    {
        return $this->belongsTo(Ticket::class, 'ticket');
    }  

    public function getBrindi()
    {
        return $this->belongsTo(Brindi::class, 'brindi');
    }
}
