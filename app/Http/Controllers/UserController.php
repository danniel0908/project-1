<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users with 'user' role
     *
     * @return \Illuminate\View\View
     */
    public function driverIndex()
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Display a listing of users with 'user' role for services
     *
     * @return \Illuminate\View\View
     */
    public function services()
    {
        $users = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.services', compact('users'));
    }

    /**
     * Display the authenticated user's profile
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * Display a listing of admin users
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $officers = User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.officers', compact('officers'));
    }

    public function tmu_index()
    {
        $officers = User::where('role', 'tmu')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('users.tmuOfficers', compact('officers'));
    }

    /**
     * Store a new admin account
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'suffix' => ['nullable', 'string', 'max:20'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'phone_number' => ['required', 'string', 'max:20'],
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);
    
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['role'] = 'admin';
    
            User::create($validatedData);
    
            return redirect()->route('officers.index')->with('success', 'Admin account created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create admin account: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to create admin account.']);
        }
    }

    public function user_store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:20'],
                'password' => ['required', 'confirmed', Password::min(8),

                ],
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['role'] = 'user';

            User::create($validatedData);

            return redirect()->back()->with('success', 'user account created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create user account: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create user account.']);
        }
    }



    public function update(Request $request, $id)
{
    try {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role' => ['string', 'in:admin,user'],
            'applicant_type' => [ 'string', 'in:operator,driver'],
        ]);

        $user->update($validatedData);

        return redirect()->back()->with('success', 'User account updated successfully.');

    } catch (\Exception $e) {
        // For debugging, you might want to log the error
        \Log::error('User update error: ' . $e->getMessage());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update user: ' . $e->getMessage());
    }
}

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'Admin account deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete user');

        }
    }

    public function tmu_store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'suffix' => ['nullable', 'string', 'max:20'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone_number' => ['required', 'string', 'max:20'],
                'password' => ['required', 'confirmed', Password::min(8),

                ],
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['role'] = 'tmu';

            User::create($validatedData);

            return redirect()->back()->with('success', 'TMU account created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create account: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create admin account.']);
        }
    }
}
