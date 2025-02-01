<?php

namespace App\Imports;

use App\Models\ServiceApplication;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class PrivateServiceapplicationImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $existingRecord = ServiceApplication::where('drivers_name', $row['drivers_name'])->first();
        if ($existingRecord) {
            return null; 
        }

        return new ServiceApplication([
            'custom_id' => $row['custom_id'],
            'Service_name'=> $row['service_name'],
            'Applicants_name' => $row['applicants_name'],
            'Contact_No_1' => $row['contact_no_1'],
            'Address1' => $row['address1'],
            'Drivers_name' => $row['drivers_name'],
            'Contact_No_2' => $row['contact_no_2'],
            'Address_2' => $row['address_2'],
            'Gender'=> $row['gender'],
            'age'=> $row['age'],
            'Body_no' => $row['body_no'],
            'Plate_no' => $row['plate_no'],
            'Make' => $row['make'],
            'Engine_no' => $row['engine_no'],
            'Chassis_no' => $row['chassis_no'],
        ]);
    }
}

