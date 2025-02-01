<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violator extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'violator_name',
        'violation_details',
        'fee',
        'violation_date',
    ];

protected $casts = [
    'violation_date' => 'date',
];

    
}
