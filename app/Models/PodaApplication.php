<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodaApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'custom_id',
        'user_id',
        'PODA_Association',

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
        'Sticker_no',
        'Unit_no1',
        'Unit_no2',
        'Unit_no3',
        'Unit_no4',
        'Unit_no5',
        'Unit_no6',
        'Unit_no8',
        'Unit_no9',
        'Unit_no10',
        'Unit_no11',
        'Unit_no12',
        'remarks',
        'Status',
    ];
    protected $table = 'PODAapplication';

    public function requirements()
        {
            return $this->hasMany(PodaRequirements::class, 'poda_application_id');
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
