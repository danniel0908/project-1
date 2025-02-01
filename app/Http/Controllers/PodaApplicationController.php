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

use App\Imports\PodaApplicationImport;

use App\Models\PodaApplication;
use App\Models\PodaRequirement;
use App\Models\TodaApplicationHistory;
use App\Models\PredefinedMessage;

class PodaApplicationController extends Controller
{
    protected $drive;
    protected $folderId;
    private $requirementType = 'application_form';

    public function __construct()
    {
         // Initialize Google Drive client
         $client = new \Google\Client();
         $client->setClientId(config('services.google.client_id'));
         $client->setClientSecret(config('services.google.client_secret'));
         $client->refreshToken(config('services.google.refresh_token'));
         
         // Set up Drive service
         $this->drive = new \Google\Service\Drive($client);
         $this->folderId = config('services.google.poda_application_folder');
    }

    private function getDeviceType($userAgent)
    {
        return preg_match('/mobile/i', $userAgent) ? 'mobile' : 'desktop';
    }

    private function getBrowserType($userAgent)
    {
        if (preg_match('/Edg/i', $userAgent)) {
            return 'edge';
        } elseif (preg_match('/OPR|Opera/i', $userAgent)) {
            return 'opera';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            return 'safari';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            return 'chrome';
        } elseif (preg_match('/Trident/i', $userAgent) || preg_match('/MSIE/i', $userAgent)) {
            return 'internet_explorer';
        }
        return 'other';
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $podaApplications = PodaApplication::where(function($query) use ($search) {
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('applicant_first_name', 'like', '%'.$search.'%')
                      ->orWhere('applicant_middle_name', 'like', '%'.$search.'%')
                      ->orWhere('applicant_last_name', 'like', '%'.$search.'%')
                      ->orWhere('driver_first_name', 'like', '%'.$search.'%')
                      ->orWhere('driver_middle_name', 'like', '%'.$search.'%')
                      ->orWhere('driver_last_name', 'like', '%'.$search.'%')
                      ->orWhere('plate_no', 'like', '%'.$search.'%')
                      ->orWhere('poda_association', 'like', '%'.$search.'%');
                });
            }
        })
        ->latest()
        ->paginate(10);

        $totalRequirements = 6;

        foreach ($podaApplications as $application) {
            $submittedRequirementsCount = $application->requirements()->count();
            $application->progressPercentage = ($submittedRequirementsCount / $totalRequirements) * 100;
        }

        return view('admin.poda-application.index', compact('podaApplications'));
    }

    public function create()
    {
        return view('admin.poda-application.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $application = $this->processApplication($request);
            $this->generateAndUploadPdf($application);
            
            DB::commit();
            
            return $this->getRedirectResponse($request->user()->role, $application);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PODA Application creation error: ' . $e->getMessage());
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
        return PodaApplication::create($applicationData);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'poda_association' => 'required',
            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',
            'contact_no_1' => 'required',
            'driver_first_name' => 'required',
            'driver_last_name' => 'required',
            'contact_no_2' => 'required',
            'address_2' => 'required',
            'sticker_no' => 'required',
            'unit_no_1' => 'required',
            'unit_no_2' => 'nullable',
            'unit_no_3' => 'nullable',
            'unit_no_4' => 'nullable',
            'unit_no_5' => 'nullable',
            'unit_no_6' => 'nullable',
            'unit_no_8' => 'nullable',
            'unit_no_9' => 'nullable',
            'unit_no_10' => 'nullable',
            'unit_no_11' => 'nullable',
            'unit_no_12' => 'nullable',
        ]);
    }

    private function findExistingApplication(Request $request)
    {
        return PodaApplication::where('driver_first_name', $request->driver_first_name)
            ->where('driver_last_name', $request->driver_last_name)
            ->first();
    }

    private function prepareApplicationData(Request $request)
    {
        $data = $request->all();
        $data['status'] = 'pending';
        $data['user_id'] = $request->user()->role == 'admin' ? null : Auth::id();
        return $data;
    }
     
     private function generateCustomId()
     {
         $count = PODAapplication::count() + 1;
         do {
             $customId = 'poda-sp-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-2024';
             $count++;
         } while (PODAapplication::where('custom_id', $customId)->exists());
         
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
         return PDF::loadView('pdf.poda-applicant', [
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
         return $cleanOperatorName . '_PODA_Application_form_' . date('Y') . '.pdf';
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
     
         $requirement = new PodaRequirements();
         $requirement->file_name = $fileName;
         $requirement->file_path = $driveResult->id;
         $requirement->drive_link = $driveResult->webViewLink;
         $requirement->poda_application_id = $application->id;
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
             return redirect()->route('PODAapplication.index')
                 ->with('success', 'Application created successfully.');
         }
     
         session(['latest_poda_application_id' => $application->id]);
         return redirect()->route('upload.poda')
             ->with('success', 'Application created successfully. Please upload the required documents.');
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PODAapplication  $PODAapplication
     * @return \Illuminate\Http\Response
     */
    public function show(PODAapplication $PODAapplication)
    {
        $predefinedMessages = PredefinedMessage::where('is_active', true)->get();

        // Retrieve files based on the TODA application's ID
        $files = PodaRequirements::where('poda_application_id', $PODAapplication->id)->get();
        return view('admin.PODAapplication.show', compact('PODAapplication', 'files','predefinedMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PODAapplication  $PODAapplication
     * @return \Illuminate\Http\Response
     */
    public function edit(PODAapplication $PODAapplication)
    {
        return view('admin.PODAapplication.edit',compact('PODAapplication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PODAapplication  $PODAapplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PODAapplication $PODAapplication)
    {
        $request->validate([
            'PODA_Association' => 'required',

            'applicant_first_name' => 'required',
            'applicant_last_name' => 'required',

            'Contact_No_1' => 'required',
            'Address1' => 'required',

            'driver_first_name' => 'required',
            'driver_last_name' => 'required',

            'Contact_No_2' => 'required',
            'Address_2' => 'required',
            'Sticker_no'=> 'required',
            'Unit_no1'=> 'required',
            'Unit_no2',
            'Unit_no3',
            'Unit_no4',
            'Unit_no5',
            'Unit_no6',
            'Unit_no8',
            'Unit_no9',
            'Unit_no10',
            'Unit_no11',
            'Unit_no12',
        ]);

        $PODAapplication->update($request->all());

        return redirect()->back()->with('success', 'Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PODAapplication  $PODAapplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(PODAapplication $PODAapplication)
    {
        $PODAapplication->delete();

        return redirect()->route('PODAapplication.index')->with('success','Application deleted successfully');
    }

    
    public function showApplicationForm()
    {
        // Assuming you have a model TODAapplication and you retrieve the authenticated user's application
        $user = auth()->user();
        $application = PODAapplication::where('user_id', $user->id)->first();

        // Pass the existing application data to the view
        return view('users.fillup.userpoda', compact('user', 'application'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();
    
            $userAgent = request()->header('User-Agent');
            $device = $this->getDeviceType($userAgent);
            $browser = $this->getBrowserType($userAgent);
    
            $PODAapplication = PODAapplication::findOrFail($id);
    
            $validatedData = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'nullable|string|max:255',
            ]);
    
            // If trying to approve, check if all requirements are submitted
            if ($validatedData['status'] === 'approved') {
                // Get all requirements for this application
                $requirements = PodaRequirements::where('poda_application_id', $PODAapplication->id)->get();
    
                // Define required requirement types
                $requiredTypes = [
                    'Application_form',
                    'Inspection_clearance',
                    'Insurance',
                    'Barangay_Clearance',
                    'Picture',
                    'Official_Receipt'
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
    
            $oldStatus = $PODAapplication->Status;
    
            if ($oldStatus !== $validatedData['status']) {
                // Create history record
                // TODAapplicationHistory::create([
                //     'toda_application_id' => $PODAapplication->id,
                //     'admin_id' => auth()->id(),
                //     'new_status' => $validatedData['status'],
                //     'action' => 'status_change',
                //     'old_values' => ['Status' => $oldStatus],
                //     'new_values' => ['Status' => $validatedData['status']],
                //     'remarks' => $request->input('remarks'),
                //     'ip_address' => $request->ip(),
                //     'device' => $device,
                //     'browser' => $browser
                // ]);
    
                // Update application status
                $PODAapplication->update([
                    'Status' => $validatedData['status'],
                    'remarks' => $request->input('remarks')
                ]);
    
                // If status is approved, automatically approve all requirements
                if ($validatedData['status'] === 'approved') {
                    $requirements = PodaRequirements::where('poda_application_id', $PODAapplication->id)->get();
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
    
            $poda_application_id = $request->poda_application_id;
            $PODAapplication = PODAapplication::findOrFail($poda_application_id);
    
            $requirementTypes = [
                'Application_form', 'Inspection_clearance', 'Insurance',
                'Barangay_Clearance', 'Picture', 'Official_Receipt'
            ];
    
            $officialReceiptApproved = false;
    
            // Loop through all requirement types
            foreach ($requirementTypes as $type) {
                $file = $request->file("files.$type");
                $remark = $request->input("remarks.$type");
    
                // Find the existing requirement record
                $requirement = PodaRequirements::where([
                    'poda_application_id' => $poda_application_id,
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
    
                        // Check if this is the Official Receipt and it's being approved
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
                $allRequirementsApproved = $this->checkAllRequirementsApproved($poda_application_id);
                
                if ($allRequirementsApproved) {
                    $PODAapplication->Status = 'approved';
                    $PODAapplication->save();
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
    
    private function checkAllRequirementsApproved($poda_application_id)
    {
        $requirements = PodaRequirements::where('poda_application_id', $poda_application_id)->get();
        
        foreach ($requirements as $requirement) {
            if ($requirement->status !== 'approved') {
                return false;
            }
        }
        
        return true;
    }

    public function editApplication($id)
    {
        $application = PODAapplication::find($id);
        $files = PodaRequirements::where('poda_application_id', $id)->get();


        // Pass the existing application data to the view
        return view('users.fillup.edit.userpoda', compact('application','files'));
    }
    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new PODAapplicationImport, $request->file('file'));

        return back()->with('success', 'Excel file uploaded and data imported successfully!');
    }


    public function updateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);
    
        try {
            $application = PODAapplication::findOrFail($id);
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
