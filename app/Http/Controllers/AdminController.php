<?php

namespace App\Http\Controllers;

use App\Models\TodaApplication;
use App\Models\PodaApplication;
use App\Models\PpfApplication;
use App\Models\ServiceApplication;
use App\Models\PodaDropping;
use App\Models\TodaDropping;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $toda_applicants_count = TodaApplication::count();
        $poda_applicants_count = PodaApplication::count();
        $ppf_applicants_count = PpfApplication::count();
        $service_applicants_count = ServiceApplication::count();
        $user_count = User::where('role', 'user')->count();
        $toda_droppings_count = TodaDropping::count();
        $poda_droppings_count = PodaDropping::count();
    
        return view('admin.dashboard', [
            'toda_applicants_count' => $toda_applicants_count,
            'poda_applicants_count' => $poda_applicants_count,
            'ppf_applicants_count' => $ppf_applicants_count,
            'service_applicants_count' => $service_applicants_count,
            'user_count' => $user_count,
            'toda_droppings_count' => $toda_droppings_count,
            'poda_droppings_count' => $poda_droppings_count
        ]);
    }

    public function superDashboard()
    {
        $toda_applicants_count = TodaApplication::count();
        $poda_applicants_count = PodaApplication::count();
        $ppf_applicants_count = PpfApplication::count();
        $user_count = User::where('role', 'user')->count();
        $toda_droppings_count = TodaDropping::count();
        $poda_droppings_count = PodaDropping::count();
    
        return view('admin.superdashboard', [
            'toda_applicants_count' => $toda_applicants_count,
            'poda_applicants_count' => $poda_applicants_count,
            'ppf_applicants_count' => $ppf_applicants_count,
            'user_count' => $user_count,
            'toda_droppings_count' => $toda_droppings_count,
            'poda_droppings_count' => $poda_droppings_count
        ]);
    }

    public function officers()
    {
        $officers = User::where('role', 'admin')->get();
        return view('users.officers', compact('officers'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'phone_number' => 'nullable|string|max:15',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['success' => true, 'message' => 'Admin account updated successfully!']);
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json(['success' => true, 'message' => 'Admin account deleted successfully!']);
    }
}
