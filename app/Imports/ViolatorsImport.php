<?php

namespace App\Imports;

use App\Models\Violator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Carbon\Carbon; // Import Carbon at the top of the file

class ViolatorsImport implements ToModel, WithUpserts
{
    public function model(array $row)
{
    // Check if the first column matches the expected header value
    if ($row[0] === 'Plate Number') {
        // Skip the header row
        return null;
    }

    // Check if the violation_date is valid
    $violation_date = $this->parseDate($row[4]);

    return new Violator([
        'plate_number' => $row[0],
        'violator_name' => $row[1],
        'violation_details' => $row[2],
        'fee' => (float) $row[3],
        'violation_date' => $violation_date,
    ]);
}

    public function uniqueBy()
    {
        return 'plate_number'; // Ensures unique plate numbers
    }

    /**
     * Parse the violation date safely
     */
    private function parseDate($date)
    {
        \Log::info('Raw date value from Excel: ' . json_encode($date)); // Log the raw value
    
        if (empty($date)) {
            return now()->format('Y-m-d'); // Fallback for empty dates
        }
    
        try {
            if (is_numeric($date)) {
                // Handle Excel serial date format
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } elseif ($date instanceof \DateTime) {
                // Handle DateTime object
                return $date->format('Y-m-d');
            } else {
                // Handle string date
                return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            }
        } catch (\Exception $e) {
            \Log::error('Error parsing date: ' . $e->getMessage());
            return now()->format('Y-m-d'); // Fallback for errors
        }
    }
    

}
