<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Queue;
use App\Models\Patient;

class QueueController extends Controller
{
    public function index()
    {
        // Get queues for today
        $queues = Queue::whereDate('created_at', today())
            ->orderBy('status', 'asc') // waiting first
            ->orderBy('id', 'asc')
            ->get();
            
        $currentQueue = Queue::whereDate('created_at', today())
            ->where('status', 'called')
            ->latest('updated_at')
            ->first();

        return view('queues.index', compact('queues', 'currentQueue'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('queues.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'poli' => 'required|string',
        ]);

        // Generate Queue Number
        // Format: [Poli Code][Number] e.g. G001, D001
        $prefix = strtoupper(substr($validated['poli'], 0, 1));
        
        $lastQueue = Queue::whereDate('created_at', today())
            ->where('poli', $validated['poli'])
            ->latest()
            ->first();

        $number = 1;
        if ($lastQueue) {
            // Extract number from string like G001
            $lastNumber = (int) substr($lastQueue->number, 1);
            $number = $lastNumber + 1;
        }

        $queueNumber = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

        Queue::create([
            'patient_id' => $validated['patient_id'],
            'poli' => $validated['poli'],
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
}
