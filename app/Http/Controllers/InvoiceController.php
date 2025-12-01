<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::where('status', 'completed')
            ->doesntHave('invoice') // Assuming we add this relationship to Appointment later or handle it manually
            ->get();
            
        return view('invoices.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'patient_id' => $validated['patient_id'],
            'appointment_id' => $validated['appointment_id'],
            'invoice_number' => 'INV-' . time(),
            'status' => 'unpaid',
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $invoice->items()->create($item);
            $total += $item['amount'];
        }

        $invoice->update(['total_amount' => $total]);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'items', 'appointment.doctor']);
        return view('invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);

        // Update Appointment and Queue status to 'completed'
        if ($invoice->appointment) {
            $invoice->appointment->update(['status' => 'completed']);
            
            if ($invoice->appointment->queue) {
                $invoice->appointment->queue->update(['status' => 'completed']);
            }
        }

        return redirect()->back()->with('success', 'Invoice marked as paid. Queue completed.');
    }
}
