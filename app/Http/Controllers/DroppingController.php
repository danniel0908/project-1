<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Google\Service\Drive\DriveFile;
use App\Imports\TodaDroppingImport;
use App\Imports\PodaDroppingImport;
use App\Models\PodaDropping;
use App\Models\TodaDropping;
use App\Models\TodaDroppingRequirement;
use App\Models\PodaDroppingRequirement;
use App\Models\PredefinedMessage;

class DroppingController extends Controller
{
    protected $drive;
    protected $toda_folder_id;
    protected $poda_folder_id;
    private $requirementType = 'Application_form';

    public function __construct()
    {
        // Initialize Google Drive client
        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));
        
        // Set up Drive service
        $this->drive = new \Google\Service\Drive($client);
        
        // Set separate folder IDs for TODA and PODA
        $this->toda_folder_id = config('services.google.toda_dropping_folder');
        $this->poda_folder_id = config('services.google.poda_dropping_folder');
    }
    /**
     * Display a listing of the resource.
     */
    public function podaIndex(Request $request)
   {
    $search = $request->get('search');
        
        $PODAdroppings = PODAdropping::where(function($query) use ($search) {
            if ($search) {
                $query->where(function($q) use ($search) {
                    // Search in applicant name fields
                    $q->where('applicant_first_name', 'like', '%'.$search.'%')
                    ->orWhere('applicant_middle_name', 'like', '%'.$search.'%')
                    ->orWhere('applicant_last_name', 'like', '%'.$search.'%')
                    // Other fields
                    ->orWhere('Plate_no', 'like', '%'.$search.'%');
                });
            }
        })
        ->latest()
        ->paginate(10);
    
        $totalRequirements = 3; // Total number of requirements (adjust this number as needed)
    
        // Calculate progress for each application
        foreach ($PODAdroppings as $application) {
            $submittedRequirementsCount = $application->requirements()->count(); // Get the count of submitted requirements
            $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100; // Calculate the percentage
        }
    
        return view('admin.Dropping.PODA.index', compact('PODAdroppings'));
    }



     /**
     * Display a toda listing of the resource.
     *
     *  @return \Illuminate\Http\Response
     */
   public function todaIndex(Request $request)
   {
    $search = $request->get('search');
        
        $TODAdroppings = TODAdropping::where(function($query) use ($search) {
            if ($search) {
                $query->where(function($q) use ($search) {
                    // Search in applicant name fields
                    $q->where('applicant_first_name', 'like', '%'.$search.'%')
                    ->orWhere('applicant_middle_name', 'like', '%'.$search.'%')
                    ->orWhere('applicant_last_name', 'like', '%'.$search.'%')
                    // Other fields
                    ->orWhere('Plate_no', 'like', '%'.$search.'%');
                });
            }
        })
        ->latest()
        ->paginate(10);
        $totalRequirements = 3;
    
        // Calculate progress for each application
        foreach ($TODAdroppings as $application) {
            $submittedRequirementsCount = $application->requirements()->count(); // Get the count of submitted requirements
            $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100; // Calculate the percentage
        }
    
        return view('admin.Dropping.TODA.index', compact('TODAdroppings'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function createdroptoda()
    {
        return view('admin.dropping.TODA.create');
    }
    public function createdroppoda()
    {
        return view('admin.dropping.PODA.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storedroptoda(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $application = $this->processTodaDropApplication($request);
            $this->generateAndUploadTodaDropPDF($application);
            
            DB::commit();
            
            return $this->getTodaDropRedirectResponse($request->user()->role, $application);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('TODA Dropping application creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create application: ' . $e->getMessage());
        }
    }


    private function processTodaDropApplication(Request $request)
    {
        $this->validateTodaDropRequest($request);
        $existingApplication = $this->findExistingTodaDropApplication($request);
        $applicationData = $this->prepareTodaDropApplicationData($request);

        if ($existingApplication) {
            $existingApplication->update($applicationData);
            return $existingApplication;
        }

        $applicationData['custom_id'] = $this->generateTodaDropCustomId();
        return TODAdropping::create($applicationData);
    }

    private function validateTodaDropRequest(Request $request)
    {
        return $request->validate([
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',
            'Address' => 'required',
            'Contact_no' => 'required',
            'Validity_Period' => 'required',
            'Case_no' => 'required',
            'Body_no' => 'required',
            'Plate_no' => 'required',
            'Make' => 'required',
            'Engine_no' => 'required',
            'Chassis_no' => 'required',
            'reasons' => 'required',
        ]);
    }
    private function findExistingTodaDropApplication(Request $request)
    {
        return TODAdropping::where('applicant_first_name', $request->applicant_first_name)
            ->where('applicant_last_name', $request->applicant_last_name)
            ->first();
    }
    private function prepareTodaDropApplicationData(Request $request)
    {
        $data = $request->all();
        $data['Status'] = 'pending';
        $data['user_id'] = Auth::id();
        return $data;
    }
    private function generateTodaDropCustomId()
    {
        $count = TODAdropping::count() + 1;
        do {
            $customId = 'toda-drop-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
            $count++;
        } while (TODAdropping::where('custom_id', $customId)->exists());
        
        return $customId;
    }

    private function getTodaDropRedirectResponse($userRole, $application)
    {
        if ($userRole == 'admin') {
            return redirect()->route('TODADropping.index')
                ->with('success', 'Application created successfully.');
        }

        session(['latest_toda_dropping_id' => $application->id]);
        return redirect()->route('upload.todaDrop')
            ->with('success', 'Application created successfully.');
    }

    private function generateAndUploadTodaDropPDF($application)
    {
        $pdf = $this->generateTodaDropPDF($application);
        $fileName = $this->generateTodaDropFileName($application);
        $tempPath = $this->savePDFTemporarily($pdf, $fileName);
        $driveResult = $this->uploadTodaDrivePDF($tempPath, $fileName);
        $this->createTodaDropRequirementsRecord($application, $fileName, $driveResult);
        $this->cleanupTempFile($fileName);
    }

    private function generateTodaDropPDF($application)
    {
        return PDF::loadView('pdf.toda-dropping', [
            'application' => $application,
            'customId' => $application->custom_id,
            'currentDate' => now()->format('F d, Y')
        ]);
    }

    private function generateTodaDropFileName($application)
    {
        $operatorName = trim(
            $application->applicant_first_name . ' ' .
            ($application->applicant_middle_name ? $application->applicant_middle_name . ' ' : '') .
            $application->applicant_last_name . ' ' .
            ($application->applicant_suffix ?? '')
        );
        $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);
        return $cleanOperatorName . '_Dropping_Application_form_' . date('Y') . '.pdf';
    }

    private function uploadTodaDrivePDF($tempPath, $fileName)
    {
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$this->toda_folder_id]
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

    private function createTodaDropRequirementsRecord($application, $fileName, $driveResult)
    {
        if (!$driveResult || !isset($driveResult->id) || !isset($driveResult->webViewLink)) {
            throw new \Exception('Drive upload failed to return required file information');
        }

        $requirement = new todaDroppingRequirements();
        $requirement->file_name = $fileName;
        $requirement->file_path = $driveResult->id;
        $requirement->drive_link = $driveResult->webViewLink;
        $requirement->toda_dropping_id = $application->id;
        $requirement->requirement_type = $this->requirementType;
        $requirement->status = 'pending';
        
        if (!$requirement->save()) {
            throw new \Exception('Failed to create requirements record');
        }

        return $requirement;
    }

    public function storedroppoda(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $application = $this->processPodaDropApplication($request);
            $this->generateAndUploadPodaDropPDF($application);
            
            DB::commit();
            
            return $this->getPodaDropRedirectResponse($request->user()->role, $application);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PODA Dropping application creation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to create application: ' . $e->getMessage());
        }
    }

    private function processPodaDropApplication(Request $request)
    {
        $this->validatePodaDropRequest($request);
        $existingApplication = $this->findExistingPodaDropApplication($request);
        $applicationData = $this->preparePodaDropApplicationData($request);

        if ($existingApplication) {
            $existingApplication->update($applicationData);
            return $existingApplication;
        }

        $applicationData['custom_id'] = $this->generatePodaDropCustomId();
        return PODAdropping::create($applicationData);
    }
    private function validatePodaDropRequest(Request $request)
    {
        return $request->validate([
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',
            'Address' => 'required',
            'Contact_no' => 'required',
            'Validity_Period' => 'required',
            'Case_no' => 'required',
            'reasons' => 'required',
        ]);
    }
    private function findExistingPodaDropApplication(Request $request)
    {
        return PODAdropping::where('applicant_first_name', $request->applicant_first_name)
            ->where('applicant_last_name', $request->applicant_last_name)
            ->first();
    }
    private function preparePodaDropApplicationData(Request $request)
    {
        $data = $request->all();
        $data['Status'] = 'pending';
        $data['user_id'] = Auth::id();
        return $data;
    }
    private function generatePodaDropCustomId()
    {
        $count = PODAdropping::count() + 1;
        do {
            $customId = 'poda-drop-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
            $count++;
        } while (PODAdropping::where('custom_id', $customId)->exists());
        
        return $customId;
    }

    private function getPodaDropRedirectResponse($userRole, $application)
    {
        if ($userRole == 'admin') {
            return redirect()->route('PODAdropping.index')
                ->with('success', 'Application created successfully.');
        }

        session(['latest_poda_dropping_id' => $application->id]);
        return redirect()->route('upload.podaDrop')
            ->with('success', 'Application created successfully.');
    }

    private function generateAndUploadPodaDropPDF($application)
    {
        $pdf = $this->generatePodaDropPDF($application);
        $fileName = $this->generatePodaDropFileName($application);
        $tempPath = $this->savePDFTemporarily($pdf, $fileName);
        $driveResult = $this->uploadPodaDrivePDF($tempPath, $fileName);
        $this->createPodaDropRequirementsRecord($application, $fileName, $driveResult);
        $this->cleanupTempFile($fileName);
    }

    private function generatePodaDropPDF($application)
    {
        return PDF::loadView('pdf.poda-dropping', [
            'application' => $application,
            'customId' => $application->custom_id,
            'currentDate' => now()->format('F d, Y')
        ]);
    }

    private function generatePodaDropFileName($application)
    {
        $operatorName = trim(
            $application->applicant_first_name . ' ' .
            ($application->applicant_middle_name ? $application->applicant_middle_name . ' ' : '') .
            $application->applicant_last_name . ' ' .
            ($application->applicant_suffix ?? '')
        );
        $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);
        return $cleanOperatorName . '_Dropping_Application_form_' . date('Y') . '.pdf';
    }

    private function uploadPodaDrivePDF($tempPath, $fileName)
    {
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$this->poda_folder_id]
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

    private function createPodaDropRequirementsRecord($application, $fileName, $driveResult)
    {
        if (!$driveResult || !isset($driveResult->id) || !isset($driveResult->webViewLink)) {
            throw new \Exception('Drive upload failed to return required file information');
        }

        $requirement = new podaDroppingRequirements();
        $requirement->file_name = $fileName;
        $requirement->file_path = $driveResult->id;
        $requirement->drive_link = $driveResult->webViewLink;
        $requirement->poda_dropping_id = $application->id;
        $requirement->requirement_type = $this->requirementType;
        $requirement->status = 'pending';
        
        if (!$requirement->save()) {
            throw new \Exception('Failed to create requirements record');
        }

        return $requirement;
    }

    // Common helper functions

    private function savePDFTemporarily($pdf, $fileName)
    {
        $tempPath = storage_path('app/temp/' . $fileName);
        Storage::makeDirectory('temp');
        $pdf->save($tempPath);
        return $tempPath;
    }

    private function cleanupTempFile($fileName)
    {
        Storage::delete('temp/' . $fileName);
    }
        

    /**
     * Display the specified resource.
     */
    public function showtoda(TODAdropping $TODAdropping)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

        // Retrieve files based on the TODA application's ID
        $files = todaDroppingRequirements::where('toda_dropping_id', $TODAdropping->id)->get();
        return view('admin.Dropping.TODA.show', compact('TODAdropping', 'files','predefinedMessages'));
    }

     /**
     * Display the specified resource.
     */
    public function showpoda(PODAdropping $PODAdropping)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

           // Retrieve files based on the TODA application's ID
           $files = podaDroppingRequirements::where('poda_dropping_id', $PODAdropping->id)->get();
           return view('admin.Dropping.PODA.show', compact('PODAdropping', 'files','predefinedMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edittoda(TODAdropping $TODAdropping)
    {
        return view('admin.DROPPING.TODA.edit',compact('TODAdropping'));

    }
    public function editpoda(PODAdropping $PODAdropping)
    {
        return view('admin.DROPPING.PODA.edit',compact('PODAdropping'));

    }


    /**
     * Update the specified resource in storage.
     */
    public function updatedroptoda(Request $request, TODAdropping $TODAdropping)
    {
        $request->validate([
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',

            'Address'=> 'required',
            'Contact_no'=> 'required',
            'Validity_Period'=> 'required',
            'Case_no'=> 'required',
            'Body_no'=> 'required',
            'Plate_no'=> 'required',
            'Make'=> 'required',
            'Engine_no'=> 'required',
            'Chassis_no'=> 'required',
        ]);

        $TODAdropping->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    public function updatedroppoda(Request $request, PODAdropping $PODAdropping)
    {
        $request->validate([
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',

            'Address'=> 'required',
            'Contact_no'=> 'required',
            'Validity_Period'=> 'required',
            'Case_no'=> 'required',
        ]);

        $PODAdropping->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function TODAdestroy(TODAdropping $TODAdropping)
    {
        $TODAdropping->delete();

        return redirect()->route('TODADropping.index')->with('success', 'Deleted successfully');
    }
    public function PODAdestroy(PODAdropping $PODAdropping)
    {
        $PODAdropping->delete();

        return redirect()->route('PODAdropping.index')->with('deleted', 'Deleted successfully.');
    }

    public function updateStatustoda(Request $request, $id)
    {
        $TODAdropping = TODAdropping::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // If trying to approve, check if all requirements are submitted
        if ($validatedData['status'] === 'approved') {
            // Get all requirements for this application
            $requirements = todaDroppingRequirements::where('toda_dropping_id', $TODAdropping->id)->get();

            // Define required requirement types
            $requiredTypes = [
                'Application_form',
                'Current_franchise',
                'Official_Receipt',
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

            // If all requirements are submitted, proceed with approval
            $TODAdropping->update([
                'Status' => $validatedData['status'],
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
    }
    
    public function updateStatuspoda(Request $request, $id)
    {
        $PODAdropping = PODAdropping::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // If trying to approve, check if all requirements are submitted
        if ($validatedData['status'] === 'approved') {
            // Get all requirements for this application
            $requirements = podaDroppingRequirements::where('poda_dropping_id', $PODAdropping->id)->get();

            // Define required requirement types
            $requiredTypes = [
                'Application_form',
                'Current_franchise',
                'Official_Receipt',
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

            // If all requirements are submitted, proceed with approval
            $PODAdropping->update([
                'Status' => $validatedData['status'],
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
    }

    

    public function todadropApplicationForm()
    {
        $user = auth()->user();
        $application = TODAdropping::where('user_id', $user->id)->first();

        // Pass the existing application data to the view
        return view('users.fillup.usertodadrop', compact('user', 'application'));
    }
    public function podadropApplicationForm()
    {
        $user = auth()->user();
        $application = PODAdropping::where('user_id', $user->id)->first();

        // Pass the existing application data to the view
        return view('users.fillup.userpodadrop', compact('user', 'application'));
    }


    public function todaUpdatereq(Request $request)
{
    try {
        DB::beginTransaction();

        $toda_dropping_id = $request->toda_dropping_id;
        $todaDropping = TodaDropping::findOrFail($toda_dropping_id);

        $requirementTypes = [
            'Application_form',
            'Official_Receipt',
            'Current_franchise'
        ];

        $officialReceiptApproved = false;

        // Loop through all requirement types
        foreach ($requirementTypes as $type) {
            $file = $request->file("files.$type");
            $remark = $request->input("remarks.$type");

            // Find the existing requirement record
            $requirement = TodaDroppingRequirements::where([
                'toda_dropping_id' => $toda_dropping_id,
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

                // Update status if it exists in the request
                if (isset($request->status[$requirement->id])) {
                    $newStatus = $request->status[$requirement->id];
                    $oldStatus = $requirement->status;
                    $requirement->status = $newStatus;

                    // Check if this is the Official Receipt and it's being approved
                    if ($newStatus === 'approved' && ($oldStatus !== 'approved' || !$requirement->approved_by)) {
                        $requirement->approved_at = now();
                        $requirement->approved_by = auth()->user()->full_name;
                        
                        // Check if this is the Official Receipt
                        if ($type === 'Official_Receipt') {
                            $officialReceiptApproved = true;
                        }
                    } 
                    // Only reset approval info if changing from 'approved' to another status
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
            $allRequirementsApproved = $this->checkAllTodaDropRequirementsApproved($toda_dropping_id);
            
            if ($allRequirementsApproved) {
                $todaDropping->Status = 'approved';
                $todaDropping->save();
            }
        }

        DB::commit();
        return redirect()->back()->with('success', 'Requirements updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Requirements update error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
    }
}

private function checkAlltodaDropRequirementsApproved($toda_dropping_id)
{
    $requirements = TodaDroppingRequirements::where('toda_dropping_id', $toda_dropping_id)->get();
    
    foreach ($requirements as $requirement) {
        if ($requirement->status !== 'approved') {
            return false;
        }
    }
    
    return true;
}

 
    public function podaUpdatereq(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $poda_dropping_id = $request->poda_dropping_id;
            $podaDropping = PodaDropping::findOrFail($poda_dropping_id);
    
            $requirementTypes = [
                'Application_form',
                'Official_Receipt',
                'Current_franchise'
            ];
    
            $officialReceiptApproved = false;
    
            // Loop through all requirement types
            foreach ($requirementTypes as $type) {
                $file = $request->file("files.$type");
                $remark = $request->input("remarks.$type");
    
                // Find the existing requirement record
                $requirement = PodaDroppingRequirements::where([
                    'poda_dropping_id' => $poda_dropping_id,
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
    
                    // Update status if it exists in the request
                    if (isset($request->status[$requirement->id])) {
                        $newStatus = $request->status[$requirement->id];
                        $oldStatus = $requirement->status;

                        $requirement->status = $newStatus;
    
                        /// Check if this is the Official Receipt and it's being approved
                    if ($newStatus === 'approved' && ($oldStatus !== 'approved' || !$requirement->approved_by)) {
                        $requirement->approved_at = now();
                        $requirement->approved_by = auth()->user()->full_name;
                        
                        // Check if this is the Official Receipt
                        if ($type === 'Official_Receipt') {
                            $officialReceiptApproved = true;
                        }
                    } 
                    // Only reset approval info if changing from 'approved' to another status
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
                $allRequirementsApproved = $this->checkAllpodaDropRequirementsApproved($poda_dropping_id);
                
                if ($allRequirementsApproved) {
                    $podaDropping->Status = 'approved';
                    $podaDropping->save();
                }
            }
    
            DB::commit();
            return redirect()->back()->with('success', 'Requirements updated successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Requirements update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    private function checkAllpodaDropRequirementsApproved($poda_dropping_id)
    {
        $requirements = PodaDroppingRequirements::where('poda_dropping_id', $poda_dropping_id)->get();
        
        foreach ($requirements as $requirement) {
            if ($requirement->status !== 'approved') {
                return false;
            }
        }
        
        return true;
    }

    public function editTODAdrop($id)
    {
        $application = TODAdropping::find($id);
        $files = todaDroppingRequirements::where('toda_dropping_id', $id)->get();

        // Pass the existing application data to the view
        return view('users.fillup.edit.usertodadrop', compact('application','files'));
    }
    public function editPODAdrop($id)
    {
        $application = PODAdropping::find($id);
        $files = podaDroppingRequirements::where('poda_dropping_id', $id)->get();


        // Pass the existing application data to the view
        return view('users.fillup.edit.userpodadrop', compact('application','files'));
    }


    public function podaupdateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
    
        try {
            $application = PODAdropping::findOrFail($id);
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

    public function todaupdateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
    
        try {
            $application = TODAdropping::findOrFail($id);
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

    public function todauploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new TODAdroppingImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }

    public function podauploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new PODAdroppingImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }


}
