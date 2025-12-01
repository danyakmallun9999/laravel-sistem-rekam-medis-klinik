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
        if (auth()->user()->hasRole('front_office')) {
            abort(403, 'Front Office staff are not authorized to create medical records.');
        }
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medicines = \App\Models\Medicine::where('stock', '>', 0)->get();
        $selectedPatientId = $request->get('patient_id');
        $appointmentId = $request->get('appointment_id');

        return view('medical_records.create', compact('patients', 'doctors', 'medicines', 'selectedPatientId', 'appointmentId'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('front_office')) {
            abort(403, 'Front Office staff are not authorized to create medical records.');
        }
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
            'icd10_code' => 'nullable|string|max:255',
            'icd10_name' => 'nullable|string|max:255',
            'icd9_code' => 'nullable|string|max:255',
            'icd10_name' => 'nullable|string|max:255',
            'icd9_code' => 'nullable|string|max:255',
            'icd9_name' => 'nullable|string|max:255',
            'responsible_person_name' => 'nullable|string|max:255',
            'responsible_person_relationship' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'informed_consent_signed' => 'boolean',
            'discharge_status' => 'nullable|string',
            'referral_hospital' => 'nullable|string|required_if:discharge_status,Rujuk',
            'is_signed' => 'boolean',
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



        if (isset($validated['is_signed']) && $validated['is_signed']) {
            $validated['signed_at'] = now();
        }

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
        if (!auth()->user()->hasRole('admin')) {
            if (auth()->user()->hasRole('front_office')) {
                abort(403, 'You are not authorized to edit medical records.');
            }
            if (!$medicalRecord->isLatestForPatient()) {
                abort(403, 'Only the latest medical record for a patient can be edited.');
            }
        }

        $patients = Patient::all();
        $doctors = Doctor::all();
        $medicines = \App\Models\Medicine::all();
        return view('medical_records.edit', compact('medicalRecord', 'patients', 'doctors', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->hasRole('admin')) {
            if (auth()->user()->hasRole('front_office')) {
                abort(403, 'You are not authorized to edit medical records.');
            }
            if (!$medicalRecord->isLatestForPatient()) {
                abort(403, 'Only the latest medical record for a patient can be edited.');
            }
        }

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
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'body_map_data' => 'nullable|string', // JSON string
            'icd10_code' => 'nullable|string|max:255',
            'icd10_name' => 'nullable|string|max:255',
            'icd9_code' => 'nullable|string|max:255',
            'icd10_name' => 'nullable|string|max:255',
            'icd9_code' => 'nullable|string|max:255',
            'icd9_name' => 'nullable|string|max:255',
            'responsible_person_name' => 'nullable|string|max:255',
            'responsible_person_relationship' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'informed_consent_signed' => 'boolean',
            'discharge_status' => 'nullable|string',
            'referral_hospital' => 'nullable|string|required_if:discharge_status,Rujuk',
            'is_signed' => 'boolean',
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



        if (isset($validated['is_signed']) && $validated['is_signed'] && !$medicalRecord->is_signed) {
            $validated['signed_at'] = now();
        }

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
        if (auth()->user()->hasRole('admin')) {
            $medicalRecord->delete();
            return redirect()->route('medical_records.index')->with('success', 'Medical Record deleted successfully.');
        }

        // Medical records cannot be deleted by law
        abort(403, 'Deleting medical records is prohibited by law.');
    }
}
