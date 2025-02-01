<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPFapplication extends Model
{
    protected $fillable = [
        'id',
        'custom_id',
        'user_id',
        'PPF_Association',
 // Applicant's name fields
        'applicant_first_name',
        'applicant_middle_name',
        'applicant_last_name',
        'applicant_suffix',
        'Contact_No_1',
        'Address1',
// Driver's name fields
        'driver_first_name',
        'driver_middle_name',
        'driver_last_name',
        'driver_suffix',
        'Contact_No_2',
        'Address_2',
        'Body_no',
        'Plate_no',
        'Make',
        'Engine_no',
        'Chassis_no',
        'Status',
        'remarks',
    ];
    protected $table = 'PPFapplication';

    public function requirements()
    {
            return $this->hasMany(StickerRequirements::class, 'sticker_application_id');
    }

     // Accessor for full applicant name
     public function getApplicantsNameAttribute()
     {
         return trim(
             $this->applicant_first_name . ' ' .
             ($this->applicant_middle_name ? $this->applicant_middle_name . ' ' : '') .
             $this->applicant_last_name . ' ' .
             ($this->applicant_suffix ?? '')
         );
     }
 
     // Accessor for full driver name
     public function getDriversNameAttribute()
     {
         return trim(
             $this->driver_first_name . ' ' .
             ($this->driver_middle_name ? $this->driver_middle_name . ' ' : '') .
             $this->driver_last_name . ' ' .
             ($this->driver_suffix ?? '')
         );
     }
}
