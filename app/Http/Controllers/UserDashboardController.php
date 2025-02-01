<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TODAapplication;
use App\Models\PODAapplication;
use App\Models\PPFapplication;
use App\Models\ServiceApplication;
use App\Models\PODAdropping;
use App\Models\TODAdropping;
use App\Models\Violator;

class UserDashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    
    // Create user display information
    $userInfo = [
        'fullName' => trim($user->first_name . ' ' . 
                         ($user->middle_name ? $user->middle_name . ' ' : '') . 
                         $user->last_name . ' ' .
                         ($user->suffix ?? '')),
        'applicantType' => ucfirst($user->applicant_type ?? 'N/A'),
        'role' => ucfirst($user->role)
    ];

    // Fetch all application types for the logged-in user
    $applications = [
        'TODAapplications' => TODAapplication::where('user_id', $user->id)->get(),
        'PODAapplications' => PODAapplication::where('user_id', $user->id)->get(),
        'PPFapplications' => PPFapplication::where('user_id', $user->id)->get(),
        'ServiceApplications' => ServiceApplication::where('user_id', $user->id)->get(),
        'PODAdropping' => PODAdropping::where('user_id', $user->id)->get(),
        'TODAdropping' => TODAdropping::where('user_id', $user->id)->get()
    ];

    // Comprehensive violation checker for all application types
    $violations = $this->checkViolationsAcrossApplicationTypes($applications);

    // Check if there are no applications
    $noApplications = collect($applications)->every(function ($collection) {
        return $collection->isEmpty();
    });

    // Get application statistics
    $stats = [
        'totalApplications' => collect($applications)->map->count()->sum(),
        'pendingApplications' => collect($applications)->map(function ($apps) {
            return $apps->where('status', 'pending')->count();
        })->sum(),
        'approvedApplications' => collect($applications)->map(function ($apps) {
            return $apps->where('status', 'approved')->count();
        })->sum()
    ];

    return view('dashboard', [
        'userInfo' => $userInfo,
        'applications' => $applications,
        'noApplications' => $noApplications,
        'violations' => $violations,
        'stats' => $stats
    ]);
}
    /**
     * Check violations across all application types
     * 
     * @param array $applications
     * @return array
     */
    protected function checkViolationsAcrossApplicationTypes($applications)
{
    $violations = [];

    // Helper function to extract plate numbers from different application types
    $extractPlateNumbers = function($applicationType) {
        return $applicationType->pluck('Plate_no')->filter()->toArray();
    };

    // Collect plate numbers from all application types
    $plateNumbers = [];
    
    $applicationTypes = [
        'TODAapplications',
        'PODAapplications',
        'PPFapplications',
        'ServiceApplications',
        'PODAdropping',
        'TODAdropping'
    ];

    foreach ($applicationTypes as $type) {
        $plateNumbers = array_merge(
            $plateNumbers, 
            $extractPlateNumbers($applications[$type])
        );
    }

    // Remove duplicate plate numbers
    $plateNumbers = array_unique($plateNumbers);

    // Check violations for all collected plate numbers
    if (!empty($plateNumbers)) {
        $violations = Violator::whereIn('plate_number', $plateNumbers)->get();
    }

    return $violations;
}
}