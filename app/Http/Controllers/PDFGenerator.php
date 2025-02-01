<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;
use PDF; 
use App\Models\User;
use App\Models\TodaApplication;
use App\Models\PodaApplication;
use App\Models\PpfApplication;
use App\Models\ServiceApplication;
use App\Models\TodaDropping;
use App\Models\PodaDropping;
use App\Models\TodaRequirement;

class PDFGenerator extends Controller
{
    public function generateTodaID($id)
    {
        // Retrieve the TODA application data by ID
        $application = TODAapplication::find($id);
        $app_id = $application->user_id;
        $user = User::find($app_id);
    
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }
    
        // Get the user's photo
        $photo = TodaRequirements::where([
            'toda_application_id' => $application->id,
            'requirement_type' => 'Picture'
        ])->first();
    
        $photo_data = null;
        if ($photo) {

            try {
                // Initialize Google Drive client
                $client = new \Google\Client();
                $client->setClientId(config('services.google.client_id'));
                $client->setClientSecret(config('services.google.client_secret'));
                $client->refreshToken(config('services.google.refresh_token'));
                
                $drive = new \Google\Service\Drive($client);
                
                // Get the file content
                $response = $drive->files->get($photo->file_path, ['alt' => 'media']);
                $content = $response->getBody()->getContents();
                
                // Convert to base64
                $photo_data = 'data:image/jpeg;base64,' . base64_encode($content);
            } catch (\Exception $e) {
                \Log::error('Failed to fetch photo: ' . $e->getMessage());
            }
        }

        $logoPath = public_path('landing/assets/img/tru-picture.png');
        $logoData = null;
        if (file_exists($logoPath)) {
            $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        
    
        $data = [
            'name' => $application->Drivers_name,
            'address' => $application->Address1,
            'custom_id' => $application->custom_id,
            'TODA_Association' => $application->TODA_Association,
            'status' => $application->Status,
            'issue_date' => now()->toDateString(),
            'expiration_date' => now()->addYear()->toDateString(),
            'phone_number' => $application->Contact_No_2,
            'email' => $application->email,
            'photo_data' => $photo_data,
            'logoData' => $logoData

        ];
    
        // Generate PDF
        $pdf = PDF::loadView('idCard.todaID', $data);
        
        // Optional: Set PDF properties for better image handling
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOptions([
            'enable_php' => true,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
    
        return $pdf->stream('id_card.pdf');
    }

    public function generatePodaID($id)
    {
        // Retrieve the TODA application data by ID
        $application = PODAapplication::find($id);
        $app_id = $application->user_id;
        $user = User::find($app_id);

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        // Pass data to the view that will be used to generate the ID card
        $data = [
            'name' => $application->Applicants_name,
            'address' => $application->Address1,

            'custom_id' => $application->custom_id, // Unique custom ID for the application
            'PODA_Association' => $application->PODA_Association,
            'status' => $application->Status,
            'issue_date' => now()->toDateString(),
            'expiration_date' => now()->addYear()->toDateString(), // Example expiration date

            'phone_number' => $user->phone_number,
            'email' => $user->email,
        ];

        // Load the view for the ID card and pass the data
        $pdf = PDF::loadView('idCard.podaID', $data);

        // Download the generated PDF or stream it
        return $pdf->download('id_card.pdf'); // Or use ->stream('id_card.pdf') to view in browser
    }

    public function generateTodaPagpapatunay($id)
{
    // Retrieve the TODA application data by ID
    $application = TODAapplication::with(['requirements', 'history'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'driver_name' => $application->getDriversNameAttribute(),
        'toda_association' => $application->TODA_Association,
        'address' => $application->Address1,
        'contact_no' => $application->Contact_No_1,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.toda-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}

public function generatePodaPagpapatunay($id)
{
    // Retrieve the TODA application data by ID
    $application = PODAapplication::with(['requirements'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'driver_name' => $application->getDriversNameAttribute(),
        'poda_association' => $application->PODA_Association,
        'address' => $application->Address1,
        'contact_no' => $application->Contact_No_1,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.poda-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}

public function generateStickerPagpapatunay($id)
{
    // Retrieve the application data by ID
    $application = PPFapplication::with(['requirements'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'driver_name' => $application->getDriversNameAttribute(),
        'ppf_association' => $application->PPF_Association,
        'address' => $application->Address1,
        'contact_no' => $application->Contact_No_1,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.sticker-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}


public function generateServicePagpapatunay($id)
{
    // Retrieve the application data by ID
    $application = ServiceApplication::with(['requirements'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'driver_name' => $application->getDriversNameAttribute(),
        'service_name' => $application->Service_name,
        'address' => $application->Address1,
        'contact_no' => $application->Contact_No_1,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.service-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}

public function generateTodaDroppingPagpapatunay($id)
{
    // Retrieve the application data by ID
    $application = TODAdropping::with(['requirements'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'address' => $application->address,
        'validity_period' => $application->validity_period,
        'case_no' => $application->case_no,
        'contact_no' => $application->contact_no,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.toda-drop-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}
public function generatePodaDroppingPagpapatunay($id)
{
    // Retrieve the application data by ID
    $application = PODAdropping::with(['requirements'])->find($id);
    
    if (!$application) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Get approved requirements with their approval dates
    $approvedRequirements = $application->requirements()
        ->where('status', 'approved')
        ->get()
        ->map(function ($requirement) {
            return [
                'type' => $requirement->requirement_type,
                'approved_at' => $requirement->updated_at->format('F d, Y'),
                'approved_by' => $requirement->approved_by
            ];
        });

    // Get the logo
    $logoPath = public_path('landing/assets/img/tru-picture.png');
    $logoData = null;
    if (file_exists($logoPath)) {
        $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    // Prepare data for the PDF
    $data = [
        'custom_id' => $application->custom_id,
        'applicant_name' => $application->getApplicantsNameAttribute(),
        'address' => $application->address,
        'validity_period' => $application->validity_period,
        'case_no' => $application->case_no,
        'contact_no' => $application->contact_no,
        'requirements' => $approvedRequirements,
        'issue_date' => now()->format('F d, Y'),
        'logo_data' => $logoData
    ];

    // Generate PDF
    $pdf = PDF::loadView('pdf.poda-drop-pagpapatunay', $data);
    
    // Set PDF options
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOptions([
        'enable_php' => true,
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true
    ]);

    return $pdf->stream('pagpapatunay.pdf');
}
}
