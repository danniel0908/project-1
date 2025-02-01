<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodaDropping extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'custom_id',
        'user_id',
                // Applicant's name fields
                'applicant_first_name',
                'applicant_middle_name',
                'applicant_last_name',
                'applicant_suffix',

        'Address',
        'Contact_no',
        'Validity_Period',
        'Case_no',
        'Body_no',
        'Plate_no',
        'Make',
        'Engine_no',
        'Chassis_no',
        'Status',
        'reasons',
        'remarks',
    ];
    protected $table = 'TODAdropping';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        // One-to-Many relationship with TodaRequirements
    public function requirements()
    {
        return $this->hasMany(todadroppingrequirements::class, 'toda_dropping_id');
    }

    public function getApplicantsNameAttribute()
    {
        return trim(
            $this->applicant_first_name . ' ' .
            ($this->applicant_middle_name ? $this->applicant_middle_name . ' ' : '') .
            $this->applicant_last_name . ' ' .
            ($this->applicant_suffix ?? '')
        );
    }

}
