<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
        'priority',
        'last_replied_at',
        'assigned',
    ];

    protected $dates = ['last_replied_at'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Messages
    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    // Update last replied timestamp
    public function updateLastRepliedAt()
    {
        $this->update(['last_replied_at' => now()]);
    }

    // Scope for open tickets
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Scope for user's tickets
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }
    
}

