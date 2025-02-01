<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\todaDroppingRequirements;
use App\Models\TODAdropping;
use Illuminate\Support\Facades\Storage;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class TodaDroppingRequirementsController extends Controller
{
    private $drive;
    private $folder_id;

    public function __construct()
    {
        $this->initGoogleDrive();
        $this->folder_id = config('services.google.toda_dropping_folder');
    }

    private function initGoogleDrive()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));
        
        $this->drive = new Drive($client);
    }

    public function upload(Request $request, $toda_dropping_id)
    {
        try {
            // Validate the request
            $request->validate([
                'files.*' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
                'requirement_type.*' => 'required|string',
            ]);

            // Fetch the TODA application
            $todaDropping = TODAdropping::findOrFail($toda_dropping_id);
            $operatorName = trim(
                $todaDropping->applicant_first_name . ' ' .
                ($todaDropping->applicant_middle_name ? $todaDropping->applicant_middle_name . ' ' : '') .
                $todaDropping->applicant_last_name . ' ' .
                ($todaDropping->applicant_suffix ?? '')
            );
            $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $requirementTypes = $request->input('requirement_type');

                foreach ($files as $index => $file) {
                    $requirementType = $requirementTypes[$index] ?? '';
                    $fileName = $cleanOperatorName . '_' . $requirementType . '_' . date('Y') . '.' . $file->getClientOriginalExtension();
                    
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

                    // Save to database
                    $fileModel = new todaDroppingRequirements();
                    $fileModel->file_name = $fileName;
                    $fileModel->file_path = $result->id; 
                    $fileModel->drive_link = $result->webViewLink;
                    $fileModel->toda_dropping_id = $todaDropping->id;
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
        $applicationId = session('latest_toda_dropping_id');
        
        // Fetch the TODA application
        $Application = TODAdropping::where('id', $applicationId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$Application) {
            return redirect()->back()->with('error', 'TODA dropping not found.');
        }

        // Fetch existing files
        $files = todaDroppingRequirements::where('toda_dropping_id', $Application->id)->get();

        // Pass both $todaApplication and $files to the view
        return view('users.upload.todaDropRequirements', compact('Application', 'files'));
    }

    public function showuploads($id)
    {
        $Application = TODAdropping::findOrFail($id);
        $files = todaDroppingRequirements::where('toda_dropping_id', $Application->id)->get();
        
        return view('users.upload.todaDropRequirements', compact('files', 'Application'));
    }

    public function updateFile(Request $request, $file_id)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
            ]);

            $existingFile = todaDroppingRequirements::findOrFail($file_id);

            $todaDropping = TODAdropping::where('id', $existingFile->toda_dropping_id)
            ->select('applicant_first_name', 'applicant_middle_name', 'applicant_last_name', 'applicant_suffix')
            ->firstOrFail();
            // Delete old file from Google Drive

            $operatorName = trim(
                $todaDropping->applicant_first_name . ' ' .
                ($todaDropping->applicant_middle_name ? $todaDropping->applicant_middle_name . ' ' : '') .
                $todaDropping->applicant_last_name . ' ' .
                ($todaDropping->applicant_suffix ?? '')
            );
            $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);
    
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

    public function adminUpload(Request $request, $toda_dropping_id, $requirement_type)
{
    try {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        // Fetch the TODA application
        $todaDropping = TODAdropping::findOrFail($toda_dropping_id);

        $operatorName = trim(
            $todaDropping->applicant_first_name . ' ' .
            ($todaDropping->applicant_middle_name ? $todaDropping->applicant_middle_name . ' ' : '') .
            $todaDropping->applicant_last_name . ' ' .
            ($todaDropping->applicant_suffix ?? '')
        );
        $cleanOperatorName = preg_replace('/[^A-Za-z0-9\-]/', '_', $operatorName);

        $file = $request->file('file');
        $fileName = $cleanOperatorName . '_' . $requirement_type . '_Admin_' . date('Y') . '.' . $file->getClientOriginalExtension();
        
        // Check if a file already exists for this requirement type
        $existingFile = todaDroppingRequirements::where('toda_dropping_id', $toda_dropping_id)
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
        $fileModel = new todaDroppingRequirements();
        $fileModel->file_name = $fileName;
        $fileModel->file_path = $result->id;
        $fileModel->drive_link = $result->webViewLink;
        $fileModel->toda_dropping_id = $todaDropping->id;
        $fileModel->requirement_type = $requirement_type;
        $fileModel->remarks = 'admin_uploaded';
        $fileModel->status = 'approved';
        $fileModel->save();

        return redirect()->back()->with('success', 'File uploaded successfully by admin');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}

public function showpayment($id)
{
    // Fetch the TODA application
    $todaDropping = TODAdropping::findOrFail($id);
    
    // Check if all requirements except official receipt are verified
    $pendingRequirements = todaDroppingRequirements::where('toda_dropping_id', $id)
        ->where('status', '!=', 'approved')
        ->where('requirement_type', '!=', 'official_receipt')  // Exclude official receipt
        ->exists();
    
    // If other requirements are not approved, redirect back with message
    if ($pendingRequirements) {
        return redirect()->back()->with('error', 'All requirements (except Official Receipt) must be verified before proceeding to payment.');
    }
    
    // If approved, proceed to show payment page
    $files = todaDroppingRequirements::where('toda_dropping_id', $todaDropping->id)->get();
    return view('users.upload.payment.todadrop', compact('files', 'todaDropping'));
}


}
