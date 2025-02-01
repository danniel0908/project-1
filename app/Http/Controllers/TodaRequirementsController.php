<?php

namespace App\Http\Controllers;

use App\Models\TodaRequirements;
use App\Models\TODAapplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class TodaRequirementsController extends Controller
{
    private $drive;
    private $folder_id;

    public function __construct()
    {
        $this->initGoogleDrive();
        $this->folder_id = config('services.google.toda_application_folder');
    }

    private function initGoogleDrive()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));
        
        $this->drive = new Drive($client);
    }

    public function upload(Request $request, $toda_application_id)
    {
        try {
            $request->validate([
                'files.*' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
                'requirement_type.*' => 'required|string',
            ]);
            $todaApplication = TODAapplication::findOrFail($toda_application_id);

            $operatorName = trim(
                $todaApplication->applicant_first_name . ' ' .
                ($todaApplication->applicant_middle_name ? $todaApplication->applicant_middle_name . ' ' : '') .
                $todaApplication->applicant_last_name . ' ' .
                ($todaApplication->applicant_suffix ?? '')
            );
            $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $requirementTypes = $request->input('requirement_type');

                foreach ($files as $index => $file) {
                    $requirementType = $requirementTypes[$index] ?? '';
                    $fileName = $cleanOperatorName  . '_' . $requirementType . '_' . date('Y') . '.' . $file->getClientOriginalExtension();
                    
                    $fileMetadata = new DriveFile([
                        'name' => $fileName,
                        'parents' => [$this->folder_id]
                    ]);

                    $result = $this->drive->files->create($fileMetadata, [
                        'data' => file_get_contents($file->getRealPath()),
                        'mimeType' => $file->getMimeType(),
                        'uploadType' => 'multipart',
                        'fields' => 'id, webViewLink'
                    ]);

                    $fileModel = new TodaRequirements();
                    $fileModel->file_name = $fileName;
                    $fileModel->file_path = $result->id;
                    $fileModel->drive_link = $result->webViewLink;
                    $fileModel->toda_application_id = $todaApplication->id;
                    $fileModel->requirement_type = $requirementTypes[$index] ?? '';
                    $fileModel->status = 'pending';
                    $fileModel->save();
                }

                return redirect()->back()->with('success', 'Files uploaded successfully');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function showUploadForm(Request $request)
    {
        $applicationId = session('latest_toda_application_id');
        
        // Fetch the TODA application
        $todaApplication = TODAapplication::where('id', $applicationId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$todaApplication) {
            return redirect()->back()->with('error', 'TODA application not found.');
        }

        // Fetch existing files
        $files = TodaRequirements::where('toda_application_id', $todaApplication->id)->get();

        // Pass both $todaApplication and $files to the view
        return view('users.upload.todaAppRequirements', compact('todaApplication', 'files'));
    }

    public function showuploads($id)
    {
        // Fetch the TODA application associated with the logged-in user
        $todaApplication = TODAapplication::findOrFail($id);
        
        // Fetch files associated with the TODA application
        $files = TodaRequirements::where('toda_application_id', $todaApplication->id)->get();
        
        return view('users.upload.todaAppRequirements', compact('files', 'todaApplication'));
    }

    public function updateFile(Request $request, $file_id)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
            ]);

            $existingFile = TodaRequirements::findOrFail($file_id);

            $todaApplication = TODAapplication::where('id', $existingFile->toda_application_id)
                ->select('applicant_first_name', 'applicant_middle_name', 'applicant_last_name', 'applicant_suffix')
                ->firstOrFail();

            $operatorName = trim(
                $todaApplication->applicant_first_name . ' ' .
                ($todaApplication->applicant_middle_name ? $todaApplication->applicant_middle_name . ' ' : '') .
                $todaApplication->applicant_last_name . ' ' .
                ($todaApplication->applicant_suffix ?? '')
            );
            $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);

                
            // Delete old file from Google Drive
            try {
                $this->drive->files->delete($existingFile->file_path);
            } catch (\Exception $e) {
                // Log error but continue with update
                \Log::error('Failed to delete old file: ' . $e->getMessage());
            }

            // Upload new file
            $file = $request->file('file');
            $fileName = $cleanOperatorName . '_' . $existingFile->requirement_type . '_' . date('Y') . '.' . $file->getClientOriginalExtension();

            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$this->folder_id]
            ]);

            $result = $this->drive->files->create($fileMetadata, [
                'data' => file_get_contents($file->getRealPath()),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink'
            ]);

            // Update database record
            $existingFile->file_name = $fileName;
            $existingFile->file_path = $result->id;
            $existingFile->drive_link = $result->webViewLink;
            $existingFile->status = 'pending';
            $existingFile->save();

            return redirect()->back()->with('success', 'File updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function adminUpload(Request $request, $toda_application_id, $requirement_type)
{
    try {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Fetch the TODA application
        $todaApplication = TODAapplication::findOrFail($toda_application_id);

        $operatorName = trim(
            $todaApplication->applicant_first_name . ' ' .
            ($todaApplication->applicant_middle_name ? $todaApplication->applicant_middle_name . ' ' : '') .
            $todaApplication->applicant_last_name . ' ' .
            ($todaApplication->applicant_suffix ?? '')
        );
        $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);

        $file = $request->file('file');
        $fileName = $cleanOperatorName . '_' . $requirement_type . '_Admin_' . date('Y') . '.' . $file->getClientOriginalExtension();
        
        // Check if a file already exists for this requirement type
        $existingFile = TodaRequirements::where('toda_application_id', $toda_application_id)
            ->where('requirement_type', $requirement_type)
            ->first();

        // If file exists, delete the old file from Google Drive
        if ($existingFile) {
            try {
                $this->drive->files->delete($existingFile->file_path);
                $existingFile->delete(); // Remove the database record
            } catch (\Exception $e) {
                \Log::error('Failed to delete old file: ' . $e->getMessage());
            }
        }

        // Create file metadata for Google Drive
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$this->folder_id]
        ]);

        // Upload to Google Drive
        $result = $this->drive->files->create($fileMetadata, [
            'data' => file_get_contents($file->getRealPath()),
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id, webViewLink'
        ]);

        // Save file info to the database
        $fileModel = new TodaRequirements();
        $fileModel->file_name = $fileName;
        $fileModel->file_path = $result->id;
        $fileModel->drive_link = $result->webViewLink;
        $fileModel->toda_application_id = $todaApplication->id;
        $fileModel->requirement_type = $requirement_type;
        $fileModel->remarks = 'admin_uploaded';
        $fileModel->status = 'approved';
        $fileModel->save();

        if ($requirement_type === 'Official_Receipt') {
            $todaApplication->status = 'approved';
            $todaApplication->save();
        }

        return redirect()->back()->with('success', 'File uploaded successfully by admin');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}


public function showpayment($id)
{
    // Fetch the TODA application
    $todaApplication = TODAapplication::findOrFail($id);
    
    // Check if all requirements except official receipt are verified
    $pendingRequirements = TodaRequirements::where('toda_application_id', $id)
        ->where('status', '!=', 'approved')
        ->where('requirement_type', '!=', 'official_receipt')  // Exclude official receipt
        ->exists();
    
    // If other requirements are not approved, redirect back with message
    if ($pendingRequirements) {
        return redirect()->back()->with('error', 'All requirements (except Official Receipt) must be verified before proceeding to payment.');
    }
    
    // If approved, proceed to show payment page
    $files = TodaRequirements::where('toda_application_id', $todaApplication->id)->get();
    return view('users.upload.payment.toda', compact('files', 'todaApplication'));
}
}
