<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodaDroppingRequirements extends Model
{
    use HasFactory;

    // Specify the table name if different from the default pluralized form
    protected $table = 'todadroppingrequirements';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'file_name', 'file_path', 'user_id', 'remarks', 'status'
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
