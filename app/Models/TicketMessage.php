<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = [
        'ticket_id', 
        'user_id', 
        'message', 
        'is_admin_message'
    ];

    // Relationship with Ticket
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}