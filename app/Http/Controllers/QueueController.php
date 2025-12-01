<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Queue;
use App\Models\Patient;
use App\Models\Doctor; // Added this line

class QueueController extends Controller
{
    public function index()
    {
        // Get queues for today (Walk-ins only for this view)
        $queues = Queue::whereDate('created_at', today())
            ->whereHas('appointment', function($query) {
                $query->where('type', 'walk-in');
            })
            ->orderBy('status', 'asc') // waiting first
            ->orderBy('id', 'asc')
            ->get();
            
        $currentQueue = Queue::whereDate('created_at', today())
            ->where('status', 'called')
            ->latest('updated_at')
            ->first();

        return view('queues.index', compact('queues', 'currentQueue'));
    }

    public function display()
    {
        // Get queues for today for public display (Show ALL)
        $queues = Queue::whereDate('created_at', today())
            ->orderBy('status', 'asc') // waiting first
            ->orderBy('id', 'asc')
            ->get();
            
        $currentQueue = Queue::whereDate('created_at', today())
            ->where('status', 'called')
            ->latest('updated_at')
            ->first();

        return view('queues.display', compact('queues', 'currentQueue'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('queues.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id', // Optional, present if checking in
            'poli' => 'nullable|string', // Optional if checking in
            'doctor_id' => 'nullable|exists:doctors,id', // Required for walk-in
        ]);

        $appointment = null;
        $poli = $validated['poli'] ?? 'General'; // Default poli if not provided

        if (!empty($validated['appointment_id'])) {
            // CASE 1: CHECK-IN (Existing Scheduled Appointment)
            $appointment = \App\Models\Appointment::find($validated['appointment_id']);
            
            // Update status to waiting_screening
            $appointment->update([
                'status' => 'waiting_screening'
            ]);
            
            // Determine Poli based on Doctor's specialization if possible, or default
            if ($appointment->doctor && $appointment->doctor->specialization) {
                $poli = $appointment->doctor->specialization;
            }
        } else {
            // CASE 2: WALK-IN (New Appointment)
            $request->validate([
                'poli' => 'required|string',
                'doctor_id' => 'required|exists:doctors,id',
            ]);

            $appointment = \App\Models\Appointment::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'appointment_date' => now(), // Immediate
                'status' => 'waiting_screening', // Ready for screening
                'notes' => 'Walk-in Patient',
                'type' => 'walk-in',
            ]);
            
            $poli = $validated['poli'];
        }

        // 2. Generate Queue Number
        // Format: [Poli Code][Number] e.g. G001, D001
        $prefix = strtoupper(substr($poli, 0, 1));
        
        $lastQueue = Queue::whereDate('created_at', today())
            ->where('poli', $poli)
            ->latest()
            ->first();

        $number = 1;
        if ($lastQueue) {
            // Extract number from string like G001
            $lastNumber = (int) substr($lastQueue->number, 1);
            $number = $lastNumber + 1;
        }

        $queueNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        // 3. Create Queue Entry
        Queue::create([
            'patient_id' => $validated['patient_id'],
            'appointment_id' => $appointment->id,
            'poli' => $poli,
            'number' => $queueNumber,
            'status' => 'waiting',
        ]);

        return redirect()->route('queues.index')->with('success', "Queue number $queueNumber generated.");
    }

    public function updateStatus(Queue $queue, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:waiting,called,completed,skipped',
        ]);

        $queue->update(['status' => $validated['status']]);

        return redirect()->route('queues.index')->with('success', "Queue status updated to {$validated['status']}.");
    }

    public function destroy(Queue $queue)
    {
        if ($queue->status !== 'waiting') {
            return redirect()->route('queues.index')->with('error', 'Cannot delete a queue that has already been called or processed.');
        }

        $appointment = $queue->appointment;

        if ($appointment) {
            if ($appointment->type === 'walk-in') {
                // For walk-ins, delete the appointment entirely
                $appointment->delete();
                // Queue should be deleted via cascade if set up, but let's be safe and delete it if it still exists
                if ($queue->exists) {
                    $queue->delete();
                }
            } else {
                // For scheduled appointments (check-ins), revert status
                $appointment->update([
                    'status' => 'scheduled'
                ]);
                $queue->delete();
            }
        } else {
            // Just delete the queue if no appointment attached (shouldn't happen but safe fallback)
            $queue->delete();
        }

        return redirect()->route('queues.index')->with('success', 'Queue entry deleted successfully.');
    }
}
