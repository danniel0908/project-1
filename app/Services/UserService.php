<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function getFullName(): string
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}