<?php

namespace App\Imports;

use App\Models\TodaApplication;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class TodaApplicationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if the record already exists
        $existingRecord = TODAapplication::where(function ($query) use ($row) {
            $query->where('custom_id', $row['custom_id'])
                  ->orWhere('Plate_no', $row['plate_no'])
                  ->orWhere('Engine_no', $row['engine_no'])
                  ->orWhere(function ($q) use ($row) {
                      // Check for existing driver using all name fields
                      $q->where('driver_first_name', $row['driver_first_name'])
                        ->where('driver_middle_name', $row['driver_middle_name'])
                        ->where('driver_last_name', $row['driver_last_name'])
                        ->where('driver_suffix', $row['driver_suffix'] ?? '');
                  });
        })->first();
        
        if ($existingRecord) {
            // You could also throw an exception here if you want to notify about duplicates
            // throw new \Exception("Duplicate record found for: " . $row['custom_id']);
            return null; // Skip existing data
        }

        return new TODAapplication([
            'custom_id' => $row['custom_id'],
            'user_id' => $row['user_id'] ?? null,
            'TODA_Association' => $row['toda_association'],
            
            // Separated Applicant's name fields
            'applicant_first_name' => $row['applicant_first_name'],
            'applicant_middle_name' => $row['applicant_middle_name'],
            'applicant_last_name' => $row['applicant_last_name'],
            'applicant_suffix' => $row['applicant_suffix'],
            
            'Contact_No_1' => $row['contact_no_1'],
            'Address1' => $row['address1'],
            
            // Separated Driver's name fields
            'driver_first_name' => $row['driver_first_name'],
            'driver_middle_name' => $row['driver_middle_name'],
            'driver_last_name' => $row['driver_last_name'],
            'driver_suffix' => $row['driver_suffix'],
            
            'Contact_No_2' => $row['contact_no_2'],
            'Address_2' => $row['address_2'],
            'Body_no' => $row['body_no'],
            'Plate_no' => $row['plate_no'],
            'Make' => $row['make'],
            'Engine_no' => $row['engine_no'],
            'Chassis_no' => $row['chassis_no'],
            'Status' => 'pending',
        ]);
    }
}

