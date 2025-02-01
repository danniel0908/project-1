<?php

namespace App\Imports;

use App\Models\PODAdropping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class PodaDroppingImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $existingRecord = PODAdropping::where('Operator_name', $row['operator_name'])->first();
        if ($existingRecord) {
            return null; 
        }

        return new PODAdropping([
            'custom_id' => $row['custom_id'],
            'Operator_name' => $row['operator_name'],
            'Address' => $row['address'],
            'Contact_no' => $row['contact_no'],
            'Validity_Period'=> $row['validity_period'],
            'Case_no'=> $row['case_no'],
            'reasons'=> $row['reasons'],
            
        ]);
    }
}

