<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodaDroppingRequirements extends Model
{
    use HasFactory;

    // Specify the table name if different from the default pluralized form
    protected $table = 'poda_dropping_requirements';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'file_name', 'file_path', 'user_id', 'remarks', 'status'
    ];

    // If status and remarks can be null or require special handling, you could use $guarded instead
    // protected $guarded = [];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
