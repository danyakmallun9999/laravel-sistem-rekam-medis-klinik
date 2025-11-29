<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:patients,nik',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'phone' => 'required|string',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:patients,nik,' . $patient->id,
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'phone' => 'required|string',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function createAccount(Patient $patient)
    {
        if ($patient->user_id) {
            return back()->with('error', 'This patient already has an account.');
        }

        // Generate Credentials
        $email = $patient->nik . '@srme.local';
        $password = \Carbon\Carbon::parse($patient->dob)->format('dmY'); // e.g., 25121990

        // Check if user already exists (shouldn't happen if NIK is unique, but good safety)
        if (\App\Models\User::where('email', $email)->exists()) {
            return back()->with('error', 'User account with this NIK already exists.');
        }

        // Create User
        $user = \App\Models\User::create([
            'name' => $patient->name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
        ]);

        // Assign Role
        $user->assignRole('patient');

        // Link to Patient
        $patient->update(['user_id' => $user->id]);

        return back()->with('success', "Account created! Username: $patient->nik, Password: $password (Format: DDMMYYYY)");
    }
}
