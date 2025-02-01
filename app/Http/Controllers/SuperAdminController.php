<?php

namespace App\Http\Controllers;
use App\Models\TODAapplicationHistory;


use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function showAllHistory()
    {
        $history = TODAapplicationHistory::with('admin', 'application') // Load both admin and application relationships
            ->orderBy('created_at', 'desc')
            ->get();

        return view('SuperAdmin.TodaHistory', compact('history'));
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


}
