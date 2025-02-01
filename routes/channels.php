<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
    $ticket = \App\Models\SupportTicket::find($ticketId);
    
    // Allow access if:
    // 1. User owns the ticket
    // 2. User is an admin
    // 3. Ticket exists
    return $ticket && ($user->id === $ticket->user_id || $user->isAdmin());
});