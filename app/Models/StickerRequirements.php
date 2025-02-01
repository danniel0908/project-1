<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StickerRequirements extends Model
{
    use HasFactory;

    // Specify the table name if different from the default pluralized form
    protected $table = 'sticker_requirements';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'sticker_application_id',
        'file_path',
        'file_name',
        'remarks',
        'status'
    ];

    // If status and remarks can be null or require special handling, you could use $guarded instead
    // protected $guarded = [];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stickerApplication()
     {
         return $this->belongsTo(PPFapplication::class, 'sticker_application_id');
     }
}
