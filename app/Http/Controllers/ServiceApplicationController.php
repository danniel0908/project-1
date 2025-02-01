<?php

namespace App\Http\Controllers;

use App\Models\ServiceApplication;
use App\Models\PredefinedMessage;
use Illuminate\Http\Request;
use App\Models\ScheduleOfService;

use App\Models\privateServiceRequirements;
use Illuminate\Support\Facades\Auth; // Add this line


use App\Imports\PrivateServiceapplicationImport;
use Maatwebsite\Excel\Facades\Excel;

use PDF;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ServiceApplicationController extends Controller
{
   

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
         
        $this->folder_id = config('services.google.private_service_folder');

    }

    public function index(Request $request)
{
    $search = $request->get('search');
    $totalRequirements = 9;
    
    // Make sure this returns LengthAwarePaginator
    $ServiceApplications = ServiceApplication::where(function($query) use ($search) {
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
    $ServiceApplications->through(function ($application) use ($totalRequirements) {
        $submittedRequirementsCount = $application->requirements()->count();
        $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100;
        return $application;
    });

    return view('admin.ServiceApplication.index', compact('ServiceApplications'));
}

    public function create()
    {
        \Log::info('Session Data:', session()->all());
        return view('admin.ServiceApplication.create');
    }

   

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
            Log::error('Service Application creation error: ' . $e->getMessage());
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
        return ServiceApplication::create($applicationData);
    }
    
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'Service_name' => 'required|string|max:255',
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',
            'Gender' => 'required|string',
            'age' => 'required|integer',
            'Contact_No_1' => 'required|string',
            'Address1' => 'required|string',
            'driver_first_name' => 'required',
            'driver_last_name' => 'required',
            'Contact_No_2' => 'required|string',
            'Address_2' => 'required|string',
            'Body_no' => 'required|string|max:255',
            'Plate_no' => 'required|string|max:255',
            'Make' => 'required|string|max:255',
            'Engine_no' => 'required|string|max:255',
            'Chassis_no' => 'required|string|max:255',
        ]);
    }
    
    private function findExistingApplication(Request $request)
    {
        return ServiceApplication::where('driver_first_name', $request->driver_first_name)
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
        $count = ServiceApplication::count() + 1;
        do {
            $customId = 'service-sp-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
            $count++;
        } while (ServiceApplication::where('custom_id', $customId)->exists());
        
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
        return PDF::loadView('pdf.service-applicant', [
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
        return $cleanOperatorName . '_Service_Application_form_' . date('Y') . '.pdf';
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
    
        $requirement = new privateServiceRequirements();
        $requirement->file_name = $fileName;
        $requirement->file_path = $driveResult->id;
        $requirement->drive_link = $driveResult->webViewLink;
        $requirement->private_service_id = $application->id;
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
            return redirect()->route('ServiceApplication.index')
                ->with('success', 'Application created successfully.');
        }
    
        return redirect()->route('schedule.create', ['serviceApplicationId' => $application->id])
            ->with('success', 'Application created successfully. Please proceed to schedule creation.');
    }


    public function show(ServiceApplication $ServiceApplication)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

        // Retrieve files based on the TODA application's ID
        $files = privateServiceRequirements::where('private_service_id', $ServiceApplication->id)->get();
        $schedules = ScheduleOfService::where('service_application_id', $ServiceApplication->id)->get();

        return view('admin.ServiceApplication.show', compact('ServiceApplication', 'files','schedules','predefinedMessages'));

    }

    public function edit(ServiceApplication $ServiceApplication)
    {
        return view('admin.ServiceApplication.edit', compact('ServiceApplication'));
    }

    public function update(Request $request, ServiceApplication $ServiceApplication)
    {
        $request->validate([
            'Service_name' => 'required|string|max:255',
            // Applicant's name fields
            'applicant_first_name',
            'applicant_middle_name',
            'applicant_last_name',
            'Gender' => 'required|string',
            'age' => 'required|integer',
            'Contact_No_1' => 'required|string',
            'Address1' => 'required|string',
            // Driver's name fields
            'driver_first_name',
            'driver_middle_name',
            'driver_last_name',
            'Contact_No_2' => 'required|string',
            'Address_2' => 'required|string',
            'Body_no' => 'required|string|max:255',
            'Plate_no' => 'required|string|max:255',
            'Make' => 'required|string|max:255',
            'Engine_no' => 'required|string|max:255',
            'Chassis_no' => 'required|string|max:255',
        ]);

        $ServiceApplication->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    public function destroy(ServiceApplication $ServiceApplication)
    {
        $ServiceApplication->delete();

        return redirect()->back()->with('success', 'Application deleted successfully');
    }

    

    public function showApplicationForm()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Find the user's service application
        $application = ServiceApplication::where('user_id', $user->id)->first();



        // Pass the serviceApplicationId to the view
        return view('users.fillup.userpservice', [
            'user' => $user,
            'application' => $application,
            'serviceApplicationId' => $application // Pass serviceApplicationId here
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        $serviceApplication = ServiceApplication::findOrFail($id);
    
        // Validate the request data
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
    
        // If trying to approve, check if all requirements are submitted
        if ($validatedData['status'] === 'approved') {
            // Get all requirements for this application
            $requirements = privateServiceRequirements::where('private_service_id', $serviceApplication->id)->get();
    
            // Define required requirement types
            $requiredTypes = [
                'Application_form', 'Inspection_clearance', 'license', 'COR', 'Deed_of_Sale',
                'Insurance', 'Barangay_Clearance', 'Picture', 'Official_Receipt'
            ];
            $officialReceiptApproved = false;

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
            $serviceApplication->update([
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
    
            $private_service_id = $request->private_service_id;
            $privateService = ServiceApplication::findOrFail($private_service_id);
    
            $requirementTypes = [
                'Application_form', 'Inspection_clearance', 'license', 'COR', 'Deed_of_Sale',
                'Insurance', 'Barangay_Clearance', 'Picture', 'Official_Receipt'
            ];
    
            $officialReceiptApproved = false;
    
            // Loop through all requirement types
            foreach ($requirementTypes as $type) {
                $file = $request->file("files.$type");
                $remark = $request->input("remarks.$type");
    
                // Find the existing requirement record
                $requirement = privateServiceRequirements::where([
                    'private_service_id' => $private_service_id,
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
                $allRequirementsApproved = $this->checkAllRequirementsApproved($private_service_id);
                
                if ($allRequirementsApproved) {
                    $privateService->status = 'approved';
                    $privateService->save();
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
    
    private function checkAllRequirementsApproved($private_service_id)
    {
        $requirements = privateServiceRequirements::where('private_service_id', $private_service_id)
            ->get();
        
        foreach ($requirements as $requirement) {
            if ($requirement->status !== 'approved') {
                return false;
            }
        }
        
        return true;
    }

    public function editApplication($id)
    {
        $application = ServiceApplication::find($id);
        $files = privateServiceRequirements::where('private_service_id', $id)->get();


        // Pass the existing application data to the view
        return view('users.fillup.edit.userservice', compact('application','files'));
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new PrivateServiceapplicationImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }


    public function updateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
    
        try {
            $application = ServiceApplication::findOrFail($id);
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
