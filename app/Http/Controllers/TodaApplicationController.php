<?php

namespace App\Http\Controllers;


use App\Models\TODAapplication;
use App\Models\TodaRequirements;
use App\Models\TODAapplicationHistory;
use App\Models\PredefinedMessage;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Imports\TODAapplicationImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
use PDF;
use Google\Service\Drive\DriveFile;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\SendSMSController;



class TodaApplicationController extends Controller
{

    protected $smsController;
    protected $drive;
    protected $folder_id;

    private $requirementType = 'Application_form'; 

    public function __construct(SendSMSController $smsController)
    {
        $this->smsController = $smsController;

         $client = new \Google\Client();
         $client->setClientId(config('services.google.client_id'));
         $client->setClientSecret(config('services.google.client_secret'));
         $client->refreshToken(config('services.google.refresh_token'));
         
         $this->drive = new \Google\Service\Drive($client);
         
        $this->folder_id = config('services.google.toda_application_folder');

    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   // Controller: TODAApplicationController.php

    public function index(Request $request)
    {
        $search = $request->get('search');
        $sortField = $request->get('sort', 'created_at'); // Default sort by created_at
        $sortDirection = $request->get('direction', 'desc'); // Default direction is descending
        
        $query = TODAapplication::query();
        
        // Apply search filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('applicant_first_name', 'like', '%'.$search.'%')
                ->orWhere('applicant_middle_name', 'like', '%'.$search.'%')
                ->orWhere('applicant_last_name', 'like', '%'.$search.'%')
                ->orWhere('driver_first_name', 'like', '%'.$search.'%')
                ->orWhere('driver_middle_name', 'like', '%'.$search.'%')
                ->orWhere('driver_last_name', 'like', '%'.$search.'%')
                ->orWhere('Plate_no', 'like', '%'.$search.'%')
                ->orWhere('TODA_Association', 'like', '%'.$search.'%');
            });
        }
        
        // Apply sorting
        switch ($sortField) {
            case 'toda_association':
                $query->orderBy('TODA_Association', $sortDirection);
                break;
            case 'drivers_name':
                $query->orderBy('driver_last_name', $sortDirection)
                    ->orderBy('driver_first_name', $sortDirection);
                break;
            case 'contact':
                $query->orderBy('Contact_No_2', $sortDirection);
                break;
            case 'status':
                $query->orderBy('Status', $sortDirection);
                break;
            case 'progress':
                // For progress, we'll need to sort after fetching the data
                break;
            default:
                $query->orderBy('created_at', $sortDirection);
        }
        
        $TODAapplications = $query->paginate(10);
        
        $totalRequirements = 9;
        foreach ($TODAapplications as $application) {
            $submittedRequirementsCount = $application->requirements()->count();
            $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100;
        }
        
        // Special handling for progress sorting
        if ($sortField === 'progress') {
            $sorted = $TODAapplications->sortBy('progressPercentage', SORT_REGULAR, $sortDirection === 'desc');
            $TODAapplications = new \Illuminate\Pagination\LengthAwarePaginator(
                $sorted->values(),
                $TODAapplications->total(),
                $TODAapplications->perPage(),
                $TODAapplications->currentPage()
            );
        }
        
        return view('admin.TODAapplication.index', compact('TODAapplications', 'sortField', 'sortDirection'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
        {
            $user = Auth::user();
            return view('admin.TODAapplication.create',compact('user'));
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
        return TODAapplication::create($applicationData);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'TODA_Association' => 'required',
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
        return TODAapplication::where('driver_first_name', $request->driver_first_name)
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
        $count = TODAapplication::count() + 1;
        do {
            $customId = 'toda-sp-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
            $count++;
        } while (TODAapplication::where('custom_id', $customId)->exists());
        
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
        return PDF::loadView('pdf.toda-applicant', [
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

        // Ensure we request all necessary fields in the response
        $result = $this->drive->files->create($fileMetadata, [
            'data' => file_get_contents($tempPath),
            'mimeType' => 'application/pdf',
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink' // Explicitly requesting these fields
        ]);

        // Verify the upload was successful and returned required data
        if (!$result || !isset($result->id) || !isset($result->webViewLink)) {
            throw new \Exception('Drive upload failed or returned incomplete data');
        }

        return $result;
    }

    private function createRequirementsRecord($application, $fileName, $driveResult)
    {
        // Verify drive result contains necessary data
        if (!$driveResult || !isset($driveResult->id) || !isset($driveResult->webViewLink)) {
            throw new \Exception('Drive upload failed to return required file information');
        }

        // Create new requirements record with explicit values
        $requirement = new TodaRequirements();
        $requirement->file_name = $fileName;
        $requirement->file_path = $driveResult->id;
        $requirement->drive_link = $driveResult->webViewLink;
        $requirement->toda_application_id = $application->id;
        $requirement->requirement_type = $this->requirementType;
        $requirement->status = 'pending';
        
        // Save and verify the record was created
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
            return redirect()->route('TODAapplication.index')
                ->with('success', 'Application created successfully.');
        }

        session(['latest_toda_application_id' => $application->id]);
        return redirect()->route('upload.toda')
            ->with('success', 'Application created successfully. Please upload the required documents.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TODAapplication  $TODAapplication
     * @return \Illuminate\Http\Response
     */
    public function show(TODAapplication $TODAapplication)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

        // Retrieve files based on the TODA application's ID
        $files = TodaRequirements::where('toda_application_id', $TODAapplication->id)->get();
        return view('admin.TODAapplication.show', compact('TODAapplication', 'files','predefinedMessages'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TODAapplication  $TODAapplication
     * @return \Illuminate\Http\Response
     */
    public function edit(TODAapplication $TODAapplication)
    {
        return view('admin.TODAapplication.edit',compact('TODAapplication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TODAapplication  $TODAapplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TODAapplication $TODAapplication)
    {
        $request->validate([
            'TODA_Association' => 'required',
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

        $TODAapplication->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TODAapplication  $TODAapplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(TODAapplication $TODAapplication)
    {
        try {
            DB::beginTransaction();
    
            // Get device and browser info
            $userAgent = request()->header('User-Agent');
            $device = $this->getDeviceType($userAgent);
            $browser = $this->getBrowserType($userAgent);
    
            // Log the deletion in the history
            TODAapplicationHistory::create([
                'toda_application_id' => $TODAapplication->id,
                'admin_id' => auth()->id(),
                'new_status' => 'deleted',
                'action' => 'delete',
                'old_values' => $TODAapplication->toArray(),
                'remarks' => 'Application marked as deleted',
                'ip_address' => request()->ip(),
                'device' => $device,
                'browser' => $browser
            ]);
    
            // Soft delete the application
            $TODAapplication->delete();
    
            DB::commit();
            return redirect()->route('TODAapplication.index')
                            ->with('success', 'Application marked as deleted successfully');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Delete failed');
        }
    }
    
    

    
    public function showApplicationForm()
    {
        // Assuming you have a model TODAapplication and you retrieve the authenticated user's application
        $user = auth()->user();
        
        return view('users.fillup.usertoda', compact('user'));
    }

    public function editApplication($id)
    {
        $application = TODAapplication::find($id);
        $files = TodaRequirements::where('toda_application_id', $id)->get();

        // Pass the existing application data to the view
        return view('users.fillup.edit.usertoda', compact('application','files'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $userAgent = request()->header('User-Agent');
            $device = $this->getDeviceType($userAgent);
            $browser = $this->getBrowserType($userAgent);

            $TODAapplication = TODAApplication::findOrFail($id);

            $validatedData = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'nullable|string|max:255',
            ]);

            // If trying to approve, check if all requirements are submitted
            if ($validatedData['status'] === 'approved') {
                // Get all requirements for this application
                $requirements = TodaRequirements::where('toda_application_id', $TODAapplication->id)->get();

                // Define required requirement types
                $requiredTypes = [
                    'Application_form', 'Inspection_clearance', 'license', 'COR', 'Deed_of_Sale',
                    'Insurance', 'Barangay_Clearance', 'Picture', 'Official_Receipt'
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
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'Cannot approve application. Missing requirements: ' . implode(', ', $missingRequirements))
                        ->withInput();
                }
            }

            $oldStatus = $TODAapplication->Status;

            if ($oldStatus !== $validatedData['status']) {
                // Create history record
                TODAapplicationHistory::create([
                    'toda_application_id' => $TODAapplication->id,
                    'admin_id' => auth()->id(),
                    'new_status' => $validatedData['status'],
                    'action' => 'status_change',
                    'old_values' => ['Status' => $oldStatus],
                    'new_values' => ['Status' => $validatedData['status']],
                    'remarks' => $request->input('remarks'),
                    'ip_address' => $request->ip(),
                    'device' => $device,
                    'browser' => $browser
                ]);

                // Update application status
                $TODAapplication->update([
                    'Status' => $validatedData['status'],
                    'remarks' => $request->input('remarks')
                ]);

                // If status is approved, automatically approve all requirements
                if ($validatedData['status'] === 'approved') {
                    $requirements = TodaRequirements::where('toda_application_id', $TODAapplication->id)->get();
                    foreach ($requirements as $requirement) {
                        $requirement->update([
                            'status' => 'approved',
                            'remarks' => 'Automatically approved with application'
                        ]);
                    }
                }

                DB::commit();
                return redirect()->back()->with('success', 'Status updated successfully');
            }

            DB::commit();
            return redirect()->back()->with('info', 'No changes made');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Status update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Update failed');
        }
    }

    public function updatereq(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $toda_application_id = $request->toda_application_id;
            $todaApplication = TODAapplication::findOrFail($toda_application_id);
    
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
                $requirement = TodaRequirements::where([
                    'toda_application_id' => $toda_application_id,
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
                        // In all other cases, leave the approval info unchanged
                    }
    
                    $requirement->save();
                }
            }
    
            // If Official Receipt was approved, check all other requirements
            if ($officialReceiptApproved) {
                $allRequirementsApproved = $this->checkAllRequirementsApproved($toda_application_id);
                
                if ($allRequirementsApproved) {
                    $todaApplication->Status = 'approved';
                    $todaApplication->save();
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
        
        private function checkAllRequirementsApproved($toda_application_id)
        {
            $requirements = TodaRequirements::where('toda_application_id', $toda_application_id)->get();
            
            foreach ($requirements as $requirement) {
                if ($requirement->status !== 'approved') {
                    return false;
                }
            }
            
            return true;
        }


    private function getDeviceType($userAgent)
    {
        // Basic device detection based on User-Agent
        if (preg_match('/mobile/i', $userAgent)) {
            return 'Mobile';
        }
        return 'Desktop';
    }
    
    private function getBrowserType($userAgent)
    {
        if (preg_match('/Edg/i', $userAgent)) {
            return 'Edge';
        } elseif (preg_match('/OPR|Opera/i', $userAgent)) {
            return 'Opera';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            return 'Safari';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        } elseif (preg_match('/Trident/i', $userAgent) || preg_match('/MSIE/i', $userAgent)) {
            return 'Internet Explorer';
        }
        return 'Other';
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new TODAapplicationImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }

    public function updateRemarks(Request $request, $applicationId)
    {
        try {
            \Log::info('Updating remarks for application:', ['id' => $applicationId]);
            
            $application = TODAapplication::findOrFail($applicationId);
            $application->remarks = $request->remarks;
            $application->save();

            if ($request->send_sms && $application->Contact_No_1) {
                \Log::info('Preparing to send SMS for application:', [
                    'id' => $applicationId,
                    'phone' => $application->Contact_No_1
                ]);

                $smsController = new SendSMSController();
                
                // Create new request with required parameters
                $smsRequest = new Request();
                $smsRequest->merge([
                    'number' => $application->Contact_No_1,
                    'message' => $request->remarks,
                    'applicant_name' => $application->Applicants_name
                ]);

                \Log::info('Sending SMS with parameters:', $smsRequest->all());
                
                // Send SMS
                $smsResponse = $smsController->sendSMS($smsRequest);
                
                \Log::info('SMS Controller Response:', ['response' => $smsResponse]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Remarks updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in updateRemarks:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update remarks: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $application = TODAapplication::find($id);

        if (is_null($application)) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        return response()->json($application);
    }

    public function getAll()
    {
        $applications = TODAapplication::select('custom_id', 'Status')->get();
        return response()->json($applications, 200, ['Content-Type' => 'application/json']);
    }



    public function createUserAccount($id)
    {
        try {
            Log::info('Starting user account creation', ['application_id' => $id]);
    
            $application = TODAapplication::findOrFail($id);
            Log::info('Found application', ['application' => $application->toArray()]);
    
            // Validate applicant's name fields
            if (empty($application->applicant_first_name) || empty($application->applicant_last_name)) {
                throw new \Exception('Applicant first name and last name are required');
            }
    
            // Generate email using first and last name
            $email = strtolower(
                str_replace(' ', '', $application->applicant_first_name) . 
                '.' . 
                str_replace(' ', '', $application->applicant_last_name)
            ) . '@toda.com';
    
            // Check if the email is already registered
            $existingUser = User::where('email', $email)->first();
            
            if ($existingUser) {
                Log::info('Existing user found, updating application with user_id', [
                    'user_id' => $existingUser->id,
                    'email' => $email
                ]);
    
                $application->user_id = $existingUser->id;
                $application->save();
    
                return response()->json([
                    'success' => true,
                    'message' => 'Application assigned to existing user',
                    'existing_user' => true,
                    'user_name' => $existingUser->full_name,
                    'email' => $existingUser->email
                ]);
            }
    
            $password = 'POSO123'; // Simple password for testing
    
            Log::info('Attempting to create new user', [
                'email' => $email,
                'first_name' => $application->applicant_first_name,
                'last_name' => $application->applicant_last_name
            ]);
    
            // Create the user with separated name fields
            $user = User::create([
                'first_name' => $application->applicant_first_name,
                'middle_name' => $application->applicant_middle_name,
                'last_name' => $application->applicant_last_name,
                'suffix' => $application->applicant_suffix,
                'email' => $email,
                'password' => Hash::make($password),
                'phone_number' => $application->Contact_No_1 ?? null,
                'role' => 'user',
                'applicant_type' => 'operator'
            ]);
    
            $application->user_id = $user->id;
            $application->save();
    
            Log::info('New user created successfully', ['user_id' => $user->id]);
    
            return response()->json([
                'success' => true,
                'message' => 'User account created successfully',
                'phone_number' => $application->Contact_No_1 ?? null,
                'password' => $password,
                'existing_user' => false,
                'email' => $email
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error creating user account: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'error' => true,
                'message' => 'Error creating user account: ' . $e->getMessage()
            ], 500);
        }
    }

}
