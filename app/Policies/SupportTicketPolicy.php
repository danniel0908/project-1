<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupportTicket;

class SupportTicketPolicy
{
    public function view(User $user, SupportTicket $ticket)
    {
        return $user->id === $ticket->user_id;
    }

    public function addMessage(User $user, SupportTicket $ticket)
    {
        return $user->id === $ticket->user_id;
    }

    public function adminAccess(User $user, SupportTicket $ticket)
    {
        return $user->isAdmin();
    }
}