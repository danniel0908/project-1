<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleOfService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_application_id',
        'route_from',
        'route_to',
        'am_time_from',
        'am_time_to',
        'pm_time_from',
        'pm_time_to',
    ];

    // protected $casts = [
    //     'am_time_from' => 'time',
    //     'am_time_to' => 'time',
    //     'pm_time_from' => 'time',
    //     'pm_time_to' => 'time',
    // ];

    public function service_application()
    {
        return $this->belongsTo(ServiceApplication::class);
    }
}
