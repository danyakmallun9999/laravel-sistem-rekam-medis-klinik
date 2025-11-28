<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'labResults']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('doctor', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate(10);

        return view('lab.index', compact('records'));
    }

    public function create(MedicalRecord $record)
    {
        return view('lab.create', compact('record'));
    }

    public function store(Request $request, MedicalRecord $record)
    {
        $validated = $request->validate([
            'test_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $path = $request->file('file')->store('lab_results', 'public');

        LabResult::create([
            'medical_record_id' => $record->id,
            'test_name' => $validated['test_name'],
            'notes' => $validated['notes'],
            'file_path' => $path,
        ]);

        return redirect()->route('lab.index')->with('success', 'Lab result uploaded successfully.');
    }
}
