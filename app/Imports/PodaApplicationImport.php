<?php

namespace App\Imports;

use App\Models\PODAapplication;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PODAapplicationImport implements ToModel, WithHeadingRow
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

        return new PODAapplication([
            'custom_id' => $row['custom_id'] ?? null,
            'PODA_Association' => $row['poda_association'] ?? null,
            // Separated Applicant's name fields
            'applicant_first_name' => $row['applicant_first_name'] ?? null,
            'applicant_middle_name' => $row['applicant_middle_name'] ?? null,
            'applicant_last_name' => $row['applicant_last_name'] ?? null,
            'applicant_suffix' => $row['applicant_suffix'] ?? null,
            
            'Contact_No_1' => $row['contact_no_1'] ?? null,
            'Address1' => $row['address1'] ?? null,
            
            // Separated Driver's name fields
            'driver_first_name' => $row['driver_first_name'] ?? null,
            'driver_middle_name' => $row['driver_middle_name'] ?? null,
            'driver_last_name' => $row['driver_last_name'] ?? null,
            'driver_suffix' => $row['driver_suffix'] ?? null,

            'Contact_No_2' => $row['contact_no_2'] ?? null,
            'Address_2' => $row['address_2'] ?? null,
            'Sticker_no' => $row['sticker_no'] ?? null,
            'Unit_no1' => $row['unit_no1'] ?? null,
            'Unit_no2' => $row['unit_no2'] ?? null,
            'Unit_no3' => $row['unit_no3'] ?? null,
            'Unit_no4' => $row['unit_no4'] ?? null,
            'Unit_no5' => $row['unit_no5'] ?? null,
            'Unit_no6' => $row['unit_no6'] ?? null,
            'Unit_no8' => $row['unit_no8'] ?? null,
            'Unit_no9' => $row['unit_no9'] ?? null,
            'Unit_no10' => $row['unit_no10'] ?? null,
            'Unit_no11' => $row['unit_no11'] ?? null,
            'Unit_no12' => $row['unit_no12'] ?? null,
        ]);
    }
}