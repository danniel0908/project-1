<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ViolatorsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Violator;

class ViolatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Violator::query();
    
        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('plate_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('violator_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('violation_details', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Paginate the results
        $violators = $query->paginate(10);
    
        return view('tmu.dashboard', compact('violators'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new ViolatorsImport, $request->file('file'));

        return redirect()->route('violators.index')->with('success', 'Violators list uploaded successfully!');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plate_number' => 'required|string|max:255',
            'violator_name' => 'required|string|max:255',
            'violation_details' => 'required|string',
            'fee' => 'required|numeric',
            'violation_date' => 'required|date',
        ]);

        Violator::create($validatedData);

        return redirect()->route('violators.index')->with('success', 'Violator added successfully!');
    }

    public function update(Request $request, Violator $violator)
    {
        $validatedData = $request->validate([
            'plate_number' => 'required|string|max:255|unique:violators,plate_number,' . $violator->id,
            'violator_name' => 'required|string|max:255',
            'violation_details' => 'required|string',
            'fee' => 'required|numeric',
            'violation_date' => 'required|date',
        ]);

        $violator->update($validatedData);

        return redirect()->route('violators.index')->with('success', 'Violator updated successfully!');
    }

    public function destroy(Violator $violator)
    {
        $violator->delete();

        return redirect()->route('violators.index')->with('success', 'Violator deleted successfully!');
    }
}


