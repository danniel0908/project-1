<?php

namespace App\Http\Controllers;

use App\Models\PPFapplication;
use App\Models\StickerRequirements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Imports\StickerapplicationImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PredefinedMessage;

use Illuminate\Support\Facades\Storage;
use PDF;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PPFapplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $drive;
    protected $folder_id;
    private $requirementType = 'Application_form'; // Added constant for requirement type

    public function __construct()
    {
         // Initialize Google Drive client
         $client = new \Google\Client();
         $client->setClientId(config('services.google.client_id'));
         $client->setClientSecret(config('services.google.client_secret'));
         $client->refreshToken(config('services.google.refresh_token'));
         
         // Set up Drive service
         $this->drive = new \Google\Service\Drive($client);
         
        $this->folder_id = config('services.google.sticker_application_folder');

    }

     public function index(Request $request)
{
    $search = $request->get('search');
    $totalRequirements = 7;
    
    // Make sure this returns LengthAwarePaginator
    $PPFapplications = PPFapplication::where(function($query) use ($search) {
        if ($search) {
            $query->where(function($q) use ($search) {
                // Search in applicant name fields
                $q->where('applicant_first_name', 'like', '%'.$search.'%')
                ->orWhere('applicant_middle_name', 'like', '%'.$search.'%')
                ->orWhere('applicant_last_name', 'like', '%'.$search.'%')
                // Search in driver name fields
                ->orWhere('driver_first_name', 'like', '%'.$search.'%')
                ->orWhere('driver_middle_name', 'like', '%'.$search.'%')
                ->orWhere('driver_last_name', 'like', '%'.$search.'%')
                // Other fields
                ->orWhere('Plate_no', 'like', '%'.$search.'%')
                ->orWhere('TODA_Association', 'like', '%'.$search.'%');
            });
        }
    })
    ->latest()
    ->paginate(10);

    // Transform the paginated results
    $PPFapplications->through(function ($application) use ($totalRequirements) {
        $submittedRequirementsCount = $application->requirements()->count();
        $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100;
        return $application;
    });

    return view('admin.PPFapplication.index', compact('PPFapplications'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.PPFapplication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
     {
         try {
             DB::beginTransaction();
             
             $application = $this->processApplication($request);
             $this->generateAndUploadPDF($application);
             
             DB::commit();
             
             return $this->getRedirectResponse($request->user()->role, $application);
         } catch (\Exception $e) {
             DB::rollBack();
             Log::error('Application creation error: ' . $e->getMessage());
             return back()->with('error', 'Failed to create application: ' . $e->getMessage());
         }
     }
     
     private function processApplication(Request $request)
     {
         $this->validateRequest($request);
         $existingApplication = $this->findExistingApplication($request);
         $applicationData = $this->prepareApplicationData($request);
     
         if ($existingApplication) {
             $existingApplication->update($applicationData);
             return $existingApplication;
         }
     
         $applicationData['custom_id'] = $this->generateCustomId();
         return PPFapplication::create($applicationData);
     }
     
     private function validateRequest(Request $request)
     {
         return $request->validate([
             'PPF_Association' => 'required',
             'applicant_first_name' => 'required',
             'applicant_last_name' => 'required',
             'Contact_No_1' => 'required',
             'Address1' => 'required',
             'driver_first_name' => 'required',
             'driver_last_name' => 'required',
             'Contact_No_2' => 'required',
             'Address_2' => 'required',
             'Body_no' => 'required',
             'Plate_no' => 'required',
             'Make' => 'required',
             'Engine_no' => 'required',
             'Chassis_no' => 'required',
         ]);
     }
     
     private function findExistingApplication(Request $request)
     {
         return PPFapplication::where('driver_first_name', $request->driver_first_name)
             ->where('driver_last_name', $request->driver_last_name)
             ->first();
     }
     
     private function prepareApplicationData(Request $request)
     {
         $data = $request->all();
         $data['Status'] = 'pending';
         $data['user_id'] = $request->user()->role == 'admin' ? null : Auth::id();
         return $data;
     }
     
     private function generateCustomId()
     {
         $count = PPFapplication::count() + 1;
         do {
             $customId = 'ppf-sp-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
             $count++;
         } while (PPFapplication::where('custom_id', $customId)->exists());
         
         return $customId;
     }
     
     private function generateAndUploadPDF($application)
     {
         $pdf = $this->generatePDF($application);
         $fileName = $this->generateFileName($application);
         $tempPath = $this->savePDFTemporarily($pdf, $fileName);
         $driveResult = $this->uploadToDrive($tempPath, $fileName);
         $this->createRequirementsRecord($application, $fileName, $driveResult);
         $this->cleanupTempFile($fileName);
     }
     
     private function generatePDF($application)
     {
         return PDF::loadView('pdf.sticker-applicant', [
             'application' => $application,
             'customId' => $application->custom_id,
             'currentDate' => now()->format('F d, Y')
         ]);
     }
     
     private function generateFileName($application)
     {
         $operatorName = trim(
             $application->applicant_first_name . ' ' .
             ($application->applicant_middle_name ? $application->applicant_middle_name . ' ' : '') .
             $application->applicant_last_name . ' ' .
             ($application->applicant_suffix ?? '')
         );
         $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);
         return $cleanOperatorName . '_Application_form_' . date('Y') . '.pdf';
     }
     
     private function savePDFTemporarily($pdf, $fileName)
     {
         $tempPath = storage_path('app/temp/' . $fileName);
         Storage::makeDirectory('temp');
         $pdf->save($tempPath);
         return $tempPath;
     }
     
     private function uploadToDrive($tempPath, $fileName)
     {
         $fileMetadata = new DriveFile([
             'name' => $fileName,
             'parents' => [$this->folder_id]
         ]);
     
         $result = $this->drive->files->create($fileMetadata, [
             'data' => file_get_contents($tempPath),
             'mimeType' => 'application/pdf',
             'uploadType' => 'multipart',
             'fields' => 'id, webViewLink'
         ]);
     
         if (!$result || !isset($result->id) || !isset($result->webViewLink)) {
             throw new \Exception('Drive upload failed or returned incomplete data');
         }
     
         return $result;
     }
     
     private function createRequirementsRecord($application, $fileName, $driveResult)
     {
         if (!$driveResult || !isset($driveResult->id) || !isset($driveResult->webViewLink)) {
             throw new \Exception('Drive upload failed to return required file information');
         }
     
         $requirement = new StickerRequirements();
         $requirement->file_name = $fileName;
         $requirement->file_path = $driveResult->id;
         $requirement->drive_link = $driveResult->webViewLink;
         $requirement->sticker_application_id = $application->id;
         $requirement->requirement_type = $this->requirementType;
         $requirement->status = 'pending';
         
         if (!$requirement->save()) {
             throw new \Exception('Failed to create requirements record');
         }
     
         return $requirement;
     }
     
     private function cleanupTempFile($fileName)
     {
         Storage::delete('temp/' . $fileName);
     }
     
     private function getRedirectResponse($userRole, $application)
     {
         if ($userRole == 'admin') {
             return redirect()->route('PPFapplication.index')
                 ->with('success', 'Application created successfully.');
         }
     
         session(['latest_sticker_application_id' => $application->id]);
         return redirect()->route('upload.sticker')
             ->with('success', 'Application created successfully. Please upload the required documents.');
     }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PPFapplication  $PPFapplication
     * @return \Illuminate\Http\Response
     */
    public function show(PPFapplication $PPFapplication)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

         // Retrieve files based on the TODA application's ID
         $files = StickerRequirements::where('sticker_application_id', $PPFapplication->id)->get();
         return view('admin.PPFapplication.show', compact('PPFapplication', 'files','predefinedMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PPFapplication  $PPFapplication
     * @return \Illuminate\Http\Response
     */
    public function edit(PPFapplication $PPFapplication)
    {
        return view('admin.PPFapplication.edit',compact('PPFapplication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PPFapplication  $PPFapplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PPFapplication $PPFapplication)
    {
        $request->validate([
            'PPF_Association' => 'required',
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',
            'Contact_No_1' => 'required',
            'Address1' => 'required',
            'driver_first_name' => 'required',
            'driver_last_name' => 'required',
            'Contact_No_2' => 'required',
            'Address_2' => 'required',
            'Body_no' => 'required',
            'Plate_no' => 'required',
            'Make' => 'required',
            'Engine_no' => 'required',
            'Chassis_no' => 'required',
        ]);

        $PPFapplication->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PPFapplication  $PPFapplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(PPFapplication $PPFapplication)
    {
        $PPFapplication->delete();

        return redirect()->route('PPFapplication.index')->with('success','ApplicationF deleted successfully');
    }

    public function updateStatus(Request $request, $id)
{
    $PPFapplication = PPFApplication::findOrFail($id);

    // Validate the request data
    $validatedData = $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    // If trying to approve, check if all requirements are submitted
    if ($validatedData['status'] === 'approved') {
        // Get all requirements for this application
        $requirements = StickerRequirements::where('sticker_application_id', $PPFapplication->id)->get();

        // Define required requirement types
        $requiredTypes = [
            'Application_form', 'Inspection_clearance', 'COR',
            'Barangay_Clearance', 'Picture', 'Official_Receipt', 'Current_franchise'
        ];

        // Check if all required requirements are submitted
        $missingRequirements = [];
        foreach ($requiredTypes as $type) {
            $requirement = $requirements->firstWhere('requirement_type', $type);
            if (!$requirement || !$requirement->file_path) {
                $missingRequirements[] = str_replace('_', ' ', $type);
            }
        }

        // If there are missing requirements, return with error
        if (!empty($missingRequirements)) {
            return redirect()->back()
                ->with('error', 'Cannot approve application. Missing requirements: ' . implode(', ', $missingRequirements))
                ->withInput();
        }

        // Update application status
        $PPFapplication->update([
            'Status' => $validatedData['status']
        ]);

        // Update all requirements to approved status
        foreach ($requirements as $requirement) {
            $requirement->update([
                'status' => 'approved',
                'remarks' => 'Automatically approved with application'
            ]);
        }

        return redirect()->back()->with('success', 'Application and all requirements have been approved successfully');
    }

    // If status is not 'approved' or all validations pass, update the status
    $PPFapplication->update([
        'Status' => $validatedData['status']
    ]);

    return redirect()->back()->with('success', 'Status updated successfully');
}

public function updatereq(Request $request)
{
    try {
        DB::beginTransaction();

        $sticker_application_id = $request->sticker_application_id;
        $stickerApplication = PPFApplication::findOrFail($sticker_application_id);

        $requirementTypes = [
            'Application_form', 'Inspection_clearance', 'COR',
            'Barangay_Clearance', 'Picture', 'Official_Receipt', 'Current_franchise'
        ];

        $officialReceiptApproved = false;

        // Loop through all requirement types
        foreach ($requirementTypes as $type) {
            $file = $request->file("files.$type");
            $remark = $request->input("remarks.$type");

            // Find the existing requirement record
            $requirement = StickerRequirements::where([
                'sticker_application_id' => $sticker_application_id,
                'requirement_type' => $type
            ])->first();

            // If the requirement exists, update it
            if ($requirement) {
                // Update remarks
                $requirement->remarks = $remark;

                // Handle file upload if a new file is provided
                if ($file) {
                    $path = $file->store('requirements');
                    $requirement->file_path = $path;
                }

                // Update status based on the selection
                if (isset($request->status[$requirement->id])) {
                    $newStatus = $request->status[$requirement->id];
                    $oldStatus = $requirement->status;
                    $requirement->status = $newStatus;

                    if ($newStatus === 'approved' && ($oldStatus !== 'approved' || !$requirement->approved_by)) {
                        $requirement->approved_at = now();
                        $requirement->approved_by = auth()->user()->full_name;
                        
                        // Check if this is the Official Receipt
                        if ($type === 'Official_Receipt') {
                            $officialReceiptApproved = true;
                        }
                    } 
                    elseif ($oldStatus === 'approved' && $newStatus !== 'approved') {
                        $requirement->approved_at = null;
                        $requirement->approved_by = null;
                    }
                }

                $requirement->save();
            }
        }

        // If Official Receipt was approved, check all other requirements
        if ($officialReceiptApproved) {
            $allRequirementsApproved = $this->checkAllRequirementsApproved($sticker_application_id);
            
            if ($allRequirementsApproved) {
                $stickerApplication->status = 'approved';
                $stickerApplication->save();
            }
        }

        DB::commit();
        return redirect()->back()->with('success', 'Requirements updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Sticker requirements update error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
    }
}

private function checkAllRequirementsApproved($sticker_application_id)
{
    $requirements = StickerRequirements::where('sticker_application_id', $sticker_application_id)
        ->get();
    
    foreach ($requirements as $requirement) {
        if ($requirement->status !== 'approved') {
            return false;
        }
    }
    
    return true;
}

    public function showApplicationForm()
    {
        // Assuming you have a model TODAapplication and you retrieve the authenticated user's application
        $user = auth()->user();
        $application = PPFApplication::where('user_id', $user->id)->first();

        // Pass the existing application data to the view
        return view('users.fillup.userppf', compact('user', 'application'));
    }


    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new StickerapplicationImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }

    


    public function editApplication($id)
    {
        $application = PPFApplication::find($id);
        $files = StickerRequirements::where('sticker_application_id', $id)->get();


        // Pass the existing application data to the view
        return view('users.fillup.edit.usersticker', compact('application','files'));
    }

    public function updateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
    
        try {
            $application = PPFApplication::findOrFail($id);
            $application->update(['remarks' => $request->remarks]);
    
            return response()->json([
                'success' => true,
                'message' => 'Remarks updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update remarks'
            ], 500);
        }
    }

}
