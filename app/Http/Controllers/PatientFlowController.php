<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PatientFlowController extends Controller
{
    public function screening()
    {
        $appointments = Appointment::where('status', 'waiting_screening')
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date')
            ->get();
            
        return view('flow.screening', compact('appointments'));
    }

    public function consultation()
    {
        $user = auth()->user();
        // If user is a doctor, filter by their ID
        $query = Appointment::whereIn('status', ['screening_completed', 'in_consultation'])
            ->with(['patient', 'doctor']);
            
        if ($user->hasRole('doctor')) {
            $doctor = \App\Models\Doctor::where('email', $user->email)->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        }
        
        $appointments = $query->orderBy('appointment_date')->get();

        return view('flow.consultation', compact('appointments'));
    }

    public function pharmacy()
    {
        $appointments = Appointment::where('status', 'waiting_pharmacy')
            ->with(['patient', 'doctor'])
            ->orderBy('updated_at')
            ->get();

        return view('flow.pharmacy', compact('appointments'));
    }

    public function cashier()
    {
        $appointments = Appointment::where('status', 'waiting_payment')
            ->with(['patient', 'doctor'])
            ->orderBy('updated_at')
            ->get();

        return view('flow.cashier', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting_screening,screening_completed,in_consultation,consultation_completed,waiting_pharmacy,waiting_payment,completed,cancelled',
            'notes' => 'nullable|string',
            // Add validation for vitals if status is screening_completed
            'systolic' => 'required_if:status,screening_completed|numeric|nullable',
            'diastolic' => 'required_if:status,screening_completed|numeric|nullable',
            'heart_rate' => 'required_if:status,screening_completed|numeric|nullable',
            'temperature' => 'required_if:status,screening_completed|numeric|nullable',
            'weight' => 'required_if:status,screening_completed|numeric|nullable',
            'height' => 'required_if:status,screening_completed|numeric|nullable',
        ]);

        $appointment->status = $validated['status'];
        if ($request->has('notes')) {
            $appointment->notes = $validated['notes'];
        }
        $appointment->save();

        // Sync Queue Status
        if ($appointment->queue) {
            // Map Appointment Status to Queue Status
            // We will use the same status values now that we are expanding the enum
            $appointment->queue->update(['status' => $validated['status']]);
        }

        // Handle specific logic based on status
        if ($validated['status'] === 'screening_completed') {
            // Create or update medical record with vitals
            // Create or update medical record with vitals
            $record = MedicalRecord::firstOrCreate(
                [
                    'appointment_id' => $appointment->id,
                ],
                [
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'visit_date' => $appointment->appointment_date,
                    'diagnosis' => 'Pending Consultation',
                    'treatment' => 'Pending Consultation',
                ]
            );

            $record->update([
                'systolic' => $request->systolic,
                'diastolic' => $request->diastolic,
                'heart_rate' => $request->heart_rate,
                'temperature' => $request->temperature,
                'weight' => $request->weight,
                'height' => $request->height,
            ]);
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
