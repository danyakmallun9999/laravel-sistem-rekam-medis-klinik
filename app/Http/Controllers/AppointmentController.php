<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('type', 'scheduled')
            ->orderBy('appointment_date', 'asc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        // Validate Doctor Schedule
        $appointmentDate = \Carbon\Carbon::parse($validated['appointment_date']);
        $dayOfWeek = strtolower($appointmentDate->format('l'));
        $time = $appointmentDate->format('H:i:s');

        // Check availability
        $schedule = \App\Models\Schedule::where('doctor_id', $validated['doctor_id'])
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->whereTime('start_time', '<=', $time)
            ->whereTime('end_time', '>', $time)
            ->first();

        if (!$schedule) {
            return back()->withErrors(['appointment_date' => 'Doctor is not available at this time.']);
        }

        Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => $validated['appointment_date'],
            'notes' => $validated['notes'],
            'status' => 'scheduled',
            'type' => 'scheduled',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,waiting_screening,screening_completed,in_consultation,consultation_completed,waiting_pharmacy,waiting_payment,completed,cancelled',
        ]);

        $appointment->update($validated);

        return redirect()->back()->with('success', 'Appointment status updated.');
    }

    public function getDoctorSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
        ]);

        $date = \Carbon\Carbon::parse($request->date);
        $dayOfWeek = strtolower($date->format('l'));

        // Find the doctor's schedule for this day
        $schedule = \App\Models\Schedule::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        // Generate time slots (e.g., 30 minutes interval)
        $slots = [];
        $startTime = \Carbon\Carbon::parse($schedule->start_time);
        $endTime = \Carbon\Carbon::parse($schedule->end_time);
        
        // Check existing appointments to exclude taken slots
        $existingAppointments = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_date')
            ->map(function ($dt) {
                return \Carbon\Carbon::parse($dt)->format('H:i');
            })
            ->toArray();

        while ($startTime->lt($endTime)) {
            $timeString = $startTime->format('H:i');
            
            // Basic check: if slot is not already taken
            // Note: This assumes exact match. For more complex duration logic, we'd need to check ranges.
            if (!in_array($timeString, $existingAppointments)) {
                $slots[] = $timeString;
            }
            
            $startTime->addMinutes(30); // 30 min interval
        }

        return response()->json(['slots' => $slots]);
    }
}
