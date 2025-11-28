<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Medicine;
use App\Models\MedicalRecord;

class PharmacyController extends Controller
{
    // Inventory Management
    public function inventory()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('pharmacy.inventory.index', compact('medicines'));
    }

    public function create()
    {
        return view('pharmacy.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'batch_number' => 'nullable|string',
            'expired_date' => 'nullable|date',
        ]);

        Medicine::create($validated);

        return redirect()->route('pharmacy.inventory')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        return view('pharmacy.inventory.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'batch_number' => 'nullable|string',
            'expired_date' => 'nullable|date',
        ]);

        $medicine->update($validated);

        return redirect()->route('pharmacy.inventory')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('pharmacy.inventory')->with('success', 'Medicine deleted successfully.');
    }

    // Prescription Processing
    public function prescriptions()
    {
        // Get records that have prescription items
        $records = MedicalRecord::whereHas('prescriptionItems')->with(['patient', 'doctor', 'prescriptionItems.medicine'])->latest()->paginate(10);
        return view('pharmacy.prescriptions.index', compact('records'));
    }

    public function showPrescription(MedicalRecord $record)
    {
        $record->load(['patient', 'doctor', 'prescriptionItems.medicine']);
        return view('pharmacy.prescriptions.show', compact('record'));
    }

    public function dispense(MedicalRecord $record)
    {
        // Logic to deduct stock would go here
        // For now, we'll just mark it as dispensed (if we had a status column) or just deduct stock
        
        foreach ($record->prescriptionItems as $item) {
            $medicine = $item->medicine;
            if ($medicine->stock >= $item->quantity) {
                $medicine->decrement('stock', $item->quantity);
            } else {
                return back()->with('error', "Insufficient stock for {$medicine->name}.");
            }
        }

        return redirect()->route('pharmacy.prescriptions')->with('success', 'Prescription dispensed and stock updated.');
    }
}
