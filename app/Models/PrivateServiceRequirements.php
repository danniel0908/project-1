<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateServiceRequirements extends Model
{
    use HasFactory;

    // Specify the table name if different from the default pluralized form
    protected $table = 'private_service_requirements';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'private_service_id',
        'file_path',
        'file_name',
        'remarks',
        'status'
    ];


    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function privateApplication()
     {
         return $this->belongsTo(ServiceApplication::class, 'private_service_id');
     }
}
