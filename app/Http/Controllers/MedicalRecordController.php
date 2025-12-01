<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('doctor', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%");
        }

        $records = $query->latest()->paginate(10);

        return view('medical_records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medicines = \App\Models\Medicine::where('stock', '>', 0)->get();
        $selectedPatientId = $request->get('patient_id');
        $appointmentId = $request->get('appointment_id');

        return view('medical_records.create', compact('patients', 'doctors', 'medicines', 'selectedPatientId', 'appointmentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'visit_date' => 'required|date',
            'soap_data' => 'nullable|array',
            'vital_signs' => 'nullable|array',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'exists:medicines,id',
            'medicines.*.quantity' => 'integer|min:1',
            'medicines.*.instructions' => 'nullable|string',
            'medicines.*.instructions' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'body_map_data' => 'nullable|string', // JSON string
        ]);

        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('medical_records', 'public');
                $attachments[] = $path;
            }
            $validated['attachments'] = $attachments;
        }

        if (isset($validated['body_map_data'])) {
            $validated['body_map_data'] = json_decode($validated['body_map_data'], true);
        }

        // CDSS Analysis
        $record = new MedicalRecord($validated); // Temporary instance for analysis
        $validated['clinical_analysis'] = \App\Services\ClinicalDecisionSupportService::analyze($record);

        $record = MedicalRecord::create($validated);

        if ($request->has('medicines')) {
            foreach ($request->medicines as $item) {
                if (isset($item['id']) && isset($item['quantity'])) {
                    $record->prescriptionItems()->create([
                        'medicine_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'instructions' => $item['instructions'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('medical_records.index')->with('success', 'Medical Record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return view('medical_records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medicines = \App\Models\Medicine::all();
        return view('medical_records.edit', compact('medicalRecord', 'patients', 'doctors', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'visit_date' => 'required|date',
            'soap_data' => 'nullable|array',
            'vital_signs' => 'nullable|array',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'exists:medicines,id',
            'medicines.*.quantity' => 'integer|min:1',
            'medicines.*.instructions' => 'nullable|string',
            'medicines.*.instructions' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'body_map_data' => 'nullable|string', // JSON string
        ]);

        if ($request->hasFile('attachments')) {
            $attachments = $medicalRecord->attachments ?? [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('medical_records', 'public');
                $attachments[] = $path;
            }
            $validated['attachments'] = $attachments;
        }

        if (isset($validated['body_map_data'])) {
            $validated['body_map_data'] = json_decode($validated['body_map_data'], true);
        }

        // CDSS Analysis
        $medicalRecord->fill($validated); // Fill with new data for analysis
        $validated['clinical_analysis'] = \App\Services\ClinicalDecisionSupportService::analyze($medicalRecord);

        $medicalRecord->update($validated);

        // Sync medicines: Delete old ones and add new ones (simple approach)
        $medicalRecord->prescriptionItems()->delete();
        if ($request->has('medicines')) {
            foreach ($request->medicines as $item) {
                if (isset($item['id']) && isset($item['quantity'])) {
                    $medicalRecord->prescriptionItems()->create([
                        'medicine_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'instructions' => $item['instructions'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('medical_records.index')->with('success', 'Medical Record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical_records.index')->with('success', 'Medical Record deleted successfully.');
    }
}
