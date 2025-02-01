<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TODAapplication; 
use App\Models\User; 
use App\Models\TodaRequirements;
use PDF;

class TodaCerfController extends Controller
{
    public function generateTodaCerf($id)
    {
         $application = TODAapplication::find($id);

         if (!$application) {
             return redirect()->back()->with('error', 'Application not found.');
         }
 
         $data = [
             'name' => $application->Applicants_name,
             'driver_first_name'=>$application->driver_first_name,
             'driver_last_name'=>$application->driver_last_name,
             'address' => $application->Address1,
             'custom_id' => $application->custom_id, 
             'TODA_Association' => $application->TODA_Association,
             'status' => $application->Status,
             'Chassis_no'=> $application->Chassis_no,
             'Make' => $application->Make,
             'Plate_no' => $application->Plate_no,
             'Engine_no' => $application->Engine_no,
             'issue_date' => now()->toDateString(),
             'expiration_date' => now()->addYear()->toDateString(), 
         ];
 
         $pdf = PDF::loadView('idCard.todaCerf', $data);
 
         return $pdf->download('id_cerf.pdf'); 
    }
}
