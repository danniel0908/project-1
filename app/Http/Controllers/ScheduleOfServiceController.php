<?php

namespace App\Http\Controllers;

use App\Models\ScheduleOfService;
use App\Models\ServiceApplication;
use Illuminate\Http\Request;

class ScheduleOfServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $schedules = ScheduleOfService::where('route_from', 'like', '%' . $search . '%')
            ->orWhere('route_to', 'like', '%' . $search . '%')
            ->latest()
            ->get(); // Removed pagination for simplicity

        return view('schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        // Retrieve the service_application_id from the request
        $serviceApplicationId = $request->input('service_application_id');

        // Validate the request
        $request->validate([
            'service_application_id' => 'required|exists:service_applications,id', // Validate that the ID exists in the ServiceApplication model
            'route_from' => 'required|array',
            'route_to' => 'required|array',
            'route_from.*' => 'required|string|max:255',
            'route_to.*' => 'required|string|max:255',
            'am_time_from' => 'required|array',
            'am_time_to' => 'required|array',
            'pm_time_from' => 'required|array',
            'pm_time_to' => 'required|array',
            'am_time_from.*' => 'required|date_format:H:i',
            'am_time_to.*' => 'required|date_format:H:i',
            'pm_time_from.*' => 'required|date_format:H:i',
            'pm_time_to.*' => 'required|date_format:H:i',
        ]);

        // Check if service application exists
        $serviceApplication = ServiceApplication::find($serviceApplicationId);
        if (!$serviceApplication) {
            return redirect()->back()->withErrors('Service application not found.');
        }

        // Create the schedule entries
        foreach ($request->route_from as $index => $route_from) {
            ScheduleOfService::create([
                'service_application_id' => $serviceApplicationId,
                'route_from' => $route_from,
                'route_to' => $request->route_to[$index],
                'am_time_from' => $request->am_time_from[$index],
                'am_time_to' => $request->am_time_to[$index],
                'pm_time_from' => $request->pm_time_from[$index],
                'pm_time_to' => $request->pm_time_to[$index],
            ]);
        }

        // Redirect with a success message

        $userRole = request()->user()->role ?? ''; 
            if ($userRole == 'admin') {
                return redirect()->route('serviceApplication.index')->with('success', 'Schedule created successfully.');
            } elseif ($userRole == 'user') {
                return redirect()->route('schedule.create', ['serviceApplicationId' => $serviceApplication->id])->with('success', 'Application created successfully.');
            } 
    }

    public function show($service_application_id)
    {
        $serviceApplication = ServiceApplication::find($service_application_id);

        if (!$serviceApplication) {
            return redirect()->back()->with('error', 'Service Application not found.');
        }

        $schedules = ScheduleOfService::where('service_application_id', $service_application_id)->get();
        $name = $serviceApplication->Service_name;

        return view('schedules.show', compact('schedules', 'name'));
    }

    public function update(Request $request, $id)
{
    try {
        $schedule = ScheduleOfService::findOrFail($id);

        $field = $request->keys()[0]; // Get the field name from the request
        $allowedFields = ['route_from', 'route_to', 'am_time_from', 'am_time_to', 'pm_time_from', 'pm_time_to'];

        // Validate that the field is allowed
        if (!in_array($field, $allowedFields)) {
            return response()->json(['error' => 'Invalid field'], 400);
        }

        // Update the specific field with validation
        $schedule->$field = $request->input($field);
        $schedule->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error updating schedule:', ['error' => $e->getMessage()]);
        
        return response()->json(['error' => 'Update failed', 'message' => $e->getMessage()], 500);
    }
}


    



    public function destroy($id)
    {
        $schedule = ScheduleOfService::find($id);

        if (!$schedule) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }

        $schedule->delete();
        return response()->json(null, 204);
    }

    public function showScheduleForm($serviceApplicationId)
    {
        $serviceApplication = ServiceApplication::find($serviceApplicationId);

        if (!$serviceApplication) {
            return redirect()->back()->with('error', 'Service Application not found.');
        }

        $schedules = ScheduleOfService::where('service_application_id', $serviceApplicationId)->get();
        $name = $serviceApplication->Service_name;

        return view('users.fillup.schedule', compact('serviceApplication', 'schedules', 'name', 'serviceApplicationId'));
    }
}
