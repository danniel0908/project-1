<?php

namespace App\Providers;

use App\Models\SupportTicket;
use App\Policies\SupportTicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(SupportTicket::class, SupportTicketPolicy::class);
    }
}