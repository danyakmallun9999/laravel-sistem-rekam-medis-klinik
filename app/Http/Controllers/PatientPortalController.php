<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Invoice;

class PatientPortalController extends Controller
{
    public function dashboard()
    {
        $patient = auth()->user()->patient;
        
        if (!$patient) {
            abort(403, 'User is not linked to a patient record.');
        }

        $upcomingAppointments = $patient->appointments()
            ->where('status', 'scheduled')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->take(3)
            ->get();

        $recentRecords = $patient->medicalRecords()
            ->orderBy('visit_date', 'desc')
            ->take(3)
            ->get();

        $unpaidInvoices = $patient->invoices()
            ->where('status', 'unpaid')
            ->get();

        return view('patient_portal.dashboard', compact('patient', 'upcomingAppointments', 'recentRecords', 'unpaidInvoices'));
    }

    public function records()
    {
        $patient = auth()->user()->patient;
        $records = $patient->medicalRecords()->orderBy('visit_date', 'desc')->paginate(10);
        return view('patient_portal.records', compact('records'));
    }

    public function appointments()
    {
        $patient = auth()->user()->patient;
        $appointments = $patient->appointments()->orderBy('appointment_date', 'desc')->paginate(10);
        return view('patient_portal.appointments', compact('appointments'));
    }

    public function invoices()
    {
        $patient = auth()->user()->patient;
        $invoices = $patient->invoices()->orderBy('created_at', 'desc')->paginate(10);
        return view('patient_portal.invoices', compact('invoices'));
    }
}
