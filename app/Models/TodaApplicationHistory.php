<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodaApplicationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'toda_application_id',
        'admin_id',
        'new_status',
        'action',
        'old_values',
        'new_values',
        'remarks',
        'ip_address',
        'device', // Add this line
        'browser' // Add this line
    ];

    protected $table = 'TODAapplicationHistory';

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    public function application()
    {
        return $this->belongsTo(TODAapplication::class, 'toda_application_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}