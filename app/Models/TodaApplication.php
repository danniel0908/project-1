<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class TodaApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'custom_id',
        'user_id',
        'TODA_Association',

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
        'remarks'
    ];

    protected $table = 'TODAapplication';

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requirements()
    {
        return $this->hasMany(TodaRequirements::class, 'toda_application_id');
    }

    public function history()
    {
        return $this->hasMany(TODAapplicationHistory::class, 'toda_application_id');
    }

    public function createUserAccount()
    {
        // Check if user account already exists
        if ($this->user_id) {
            return null;
        }

        // Generate a random password
        $password = Str::random(10);

        // Generate email using first name and last name
        $email = strtolower(
            str_replace(' ', '', $this->applicant_first_name) . 
            '.' . 
            str_replace(' ', '', $this->applicant_last_name)
        ) . '@toda.com';

        // Create user account using applicant's information
        $user = User::create([
            'first_name' => $this->applicant_first_name,
            'middle_name' => $this->applicant_middle_name,
            'last_name' => $this->applicant_last_name,
            'suffix' => $this->applicant_suffix,
            'email' => $email,
            'password' => Hash::make($password),
            'phone_number' => $this->Contact_No_1,
            'role' => 'user',
            'applicant_type' => 'toda', // Added applicant_type for TODA applications
        ]);

        // Update the TODAapplication with the new user_id
        $this->user_id = $user->id;
        $this->save();

        return [
            'user' => $user,
            'password' => $password
        ];
    }
}