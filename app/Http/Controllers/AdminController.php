<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\TODAapplication;
use App\Models\PODAapplication;
use App\Models\PPFapplication;
use App\Models\ServiceApplication;
use App\Models\PODAdropping;
use App\Models\TODAdropping;


class AdminController extends Controller
{
    public function index(){
        $todaApplicantsCount = TODAapplication::count();
        $podaApplicantsCount = PODAapplication::count();
        $ppfApplicantsCount = ServiceApplication::count();
        $serviceApplicantsCount = PPFapplication::count();
        $userCount = User::where('role', 'user')->count();
        $todaDroppingsCount = TODADropping::count();
        $podaDroppingsCount = PODadropping::count();
    
        return view('admin.dashboard', [
            'todaApplicantsCount' => $todaApplicantsCount,
            'podaApplicantsCount' => $podaApplicantsCount,
            'ppfApplicantsCount' => $ppfApplicantsCount,
            'serviceApplicantsCount' => $serviceApplicantsCount,
            'userCount' => $userCount,
            'todaDroppingsCount' => $todaDroppingsCount,
            'podaDroppingsCount' => $podaDroppingsCount
        ]);
    }

    public function superIndex(){
        $todaApplicantsCount = TODAapplication::count();
        $podaApplicantsCount = PODAapplication::count();
        $ppfApplicantsCount = PPFapplication::count();
        $userCount = User::where('role', 'user')->count();
        $todaDroppingsCount = TODADropping::count();
        $podaDroppingsCount = PODadropping::count();
    
        return view('admin.superdashboard', [
            'todaApplicantsCount' => $todaApplicantsCount,
            'podaApplicantsCount' => $podaApplicantsCount,
            'ppfApplicantsCount' => $ppfApplicantsCount,
            'userCount' => $userCount,
            'todaDroppingsCount' => $todaDroppingsCount,
            'podaDroppingsCount' => $podaDroppingsCount
        ]);
    }
    public function officers()
    {
        // Retrieve all users from the database
        $officers = User::where('role', 'admin')->get();

        // Pass the users to the view
        return view('users.officers', compact('officers'));
    }

      // Update an existing admin
      public function update(Request $request, $id)
      {
          // Find the admin by ID
          $admin = User::findOrFail($id);

          // Validate input data
          $request->validate([
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
              'phone_number' => 'nullable|string|max:15',
          ]);

          // Update admin details
          $admin->update([
              'name' => $request->name,
              'email' => $request->email,
              'phone_number' => $request->phone_number,
          ]);

          return response()->json(['success' => true, 'message' => 'Admin account updated successfully!']);
      }

      // Delete an admin
      public function destroy($id)
      {
          // Find the admin by ID
          $admin = User::findOrFail($id);

          // Delete the admin
          $admin->delete();

          return response()->json(['success' => true, 'message' => 'Admin account deleted successfully!']);
      }
}
