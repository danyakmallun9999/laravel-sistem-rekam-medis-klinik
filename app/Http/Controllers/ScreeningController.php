<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreeningController extends Controller
{
    public function create(Appointment $appointment)
    {
        // Ensure the appointment is in the correct status
        if ($appointment->status !== 'waiting' && $appointment->status !== 'waiting_screening') {
            // Allow re-entry if already screened but not yet with doctor? 
            // For now, strict check or allow 'screening_completed' for editing?
            // Let's allow 'waiting' only for now as per flow.
        }

        $patient = $appointment->patient;
        
        // Fetch previous medical records for read-only history
        $previousRecords = MedicalRecord::where('patient_id', $patient->id)
            ->where('id', '!=', $appointment->medical_record_id) // Exclude current if exists
            ->with('doctor')
            ->latest()
            ->take(5)
            ->get();

        return view('screening.create', compact('appointment', 'patient', 'previousRecords'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'blood_pressure' => 'required|string',
            'temperature' => 'required|numeric',
            'weight' => 'required|numeric',
            'pulse' => 'nullable|numeric',
            'respiratory_rate' => 'nullable|numeric',
            'chief_complaint' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $appointment) {
            // Create or Update Medical Record
            $medicalRecord = MedicalRecord::firstOrNew([
                'appointment_id' => $appointment->id,
            ]);

            if (!$medicalRecord->exists) {
                $medicalRecord->patient_id = $appointment->patient_id;
                $medicalRecord->doctor_id = $appointment->doctor_id;
                $medicalRecord->visit_date = now();
                $medicalRecord->diagnosis = 'Pending Consultation';
                $medicalRecord->treatment = 'Pending Consultation';
            }

            // Save Vitals
            $vitalSigns = [
                'blood_pressure' => $request->blood_pressure,
                'temperature' => $request->temperature,
                'weight' => $request->weight,
                'pulse' => $request->pulse,
                'respiratory_rate' => $request->respiratory_rate,
            ];
            $medicalRecord->vital_signs = $vitalSigns;

            // Save SOAP (Subjective)
            $soapData = $medicalRecord->soap_data ?? [];
            $soapData['subjective'] = $request->chief_complaint;
            $medicalRecord->soap_data = $soapData;

            $medicalRecord->save();

            // Update Appointment Status
            $appointment->status = 'screening_completed';
            $appointment->save();

            // Update Queue Status if exists
            $queue = Queue::where('appointment_id', $appointment->id)->first();
            if ($queue) {
                $queue->status = 'screening_completed';
                $queue->save();
            }
        });

        return redirect()->route('dashboard')->with('success', 'Screening completed successfully.');
    }
}
