<?php

namespace App\Imports;

use App\Models\TodaDropping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class TodaDroppingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $existingRecord = TodaDropping::where('operator_name', $row['operator_name'])->first();
        if ($existingRecord) {
            return null; // Skip existing data
        }

        return new TodaDropping([
            'custom_id' => $row['custom_id'],
            'Operator_name' => $row['operator_name'],
            'Address' => $row['address'],
            'Contact_no' => $row['contact_no'],
            'Validity_Period'=> $row['validity_period'],
            'Case_no'=> $row['case_no'],
            'Body_no' => $row['body_no'],
            'Plate_no' => $row['plate_no'],
            'Make' => $row['make'],
            'Engine_no' => $row['engine_no'],
            'Chassis_no' => $row['chassis_no'],
            'reasons'=> $row['reasons'],
            
        ]);
    }
}

