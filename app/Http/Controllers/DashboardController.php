<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Queue;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('doctor')) {
            return $this->getDoctorDashboard($user);
        } elseif ($user->hasRole('nurse')) {
            return $this->getNurseDashboard($user);
        } elseif ($user->hasRole('front_office')) {
            return $this->getFrontOfficeDashboard($user);
        } elseif ($user->hasRole('pharmacist')) {
            return $this->getPharmacistDashboard($user);
        } else {
            return $this->getAdminDashboard($user);
        }
    }

    private function getDoctorDashboard($user)
    {
        $doctor = Doctor::where('email', $user->email)->first();
        
        $todayAppointments = 0;
        $activePatients = collect();
        $waitingPatients = collect();
        $patientsWaiting = 0;
        $patientsFinished = 0;
        $doctorSchedules = collect();

        if ($doctor) {
            $todayAppointments = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count();
            
            // Doctor Workspace Data
            $activePatients = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'in_consultation')
                ->with(['patient', 'medicalRecord'])
                ->get();

            // Patients ready for consultation (Screening Completed)
            $waitingPatients = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'screening_completed')
                ->with(['patient', 'medicalRecord'])
                ->orderBy('appointment_date')
                ->get();

            $patientsWaiting = $waitingPatients->count();
            
            // Patients finished today
            $patientsFinished = Appointment::where('doctor_id', $doctor->id)
                ->whereIn('status', ['waiting_pharmacy', 'completed'])
                ->whereDate('updated_at', today())
                ->count();

            // Doctor's Weekly Schedule
            $doctorSchedules = \App\Models\Schedule::where('doctor_id', $doctor->id)
                ->orderByRaw("FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
                ->orderBy('start_time')
                ->get();

            // Recent Medical Records (All Patients)
            $recentMedicalRecords = MedicalRecord::with(['patient'])
                ->latest()
                ->take(10)
                ->get();

            // Recent Patients
            $recentPatients = Patient::latest()->take(5)->get();
        } else {
            $recentMedicalRecords = collect();
            $recentPatients = collect();
        }

        return view('dashboards.doctor', compact(
            'todayAppointments',
            'activePatients',
            'waitingPatients',
            'patientsWaiting',
            'patientsFinished',
            'patientsFinished',
            'doctorSchedules',
            'patientsFinished',
            'doctorSchedules',
            'recentMedicalRecords',
            'recentPatients'
        ));
    }

    private function getNurseDashboard($user)
    {
        // Common Stats
        $totalPatients = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $activeQueues = Queue::whereIn('status', ['waiting', 'waiting_screening', 'screening_completed', 'in_consultation', 'waiting_pharmacy', 'waiting_payment', 'called'])->count();

        // Nurse Data
        // Fetch Appointments directly to be more robust
        $screeningQueues = Appointment::where('status', 'waiting_screening')
            ->whereHas('queue', function($q) {
                $q->where('status', 'called');
            })
            ->with(['patient', 'queue'])
            ->orderBy('appointment_date')
            ->take(10)
            ->get();

        // Charts Data (Common for non-doctors usually, but can be customized)
        $visitLabels = collect();
        $visitData = collect();
        $appointmentLabels = collect();
        $appointmentData = collect();
        
        // Simple chart data for now (same as admin)
        $monthlyVisits = MedicalRecord::selectRaw('MONTH(visit_date) as month, COUNT(*) as count')
            ->whereYear('visit_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($monthlyVisits as $visit) {
            $visitLabels->push($months[$visit->month - 1]);
            $visitData->push($visit->count);
        }

        $appointmentStats = Appointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        foreach ($appointmentStats as $stat) {
            $appointmentLabels->push(ucfirst(str_replace('_', ' ', $stat->status)));
            $appointmentData->push($stat->count);
        }

        return view('dashboards.nurse', compact(
            'totalPatients',
            'todayAppointments',
            'activeQueues',
            'screeningQueues',
            'visitLabels',
            'visitData',
            'appointmentLabels',
            'appointmentData'
        ));
    }

    private function getFrontOfficeDashboard($user)
    {
        // Stats
        $totalPatients = Patient::count();
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', today())->count();
        $pendingPaymentCount = Invoice::where('status', 'unpaid')->count();

        // Data for Walk-in Form
        $patients = Patient::select('id', 'name', 'nik')->orderBy('name')->get();
        $doctors = Doctor::all();

        // 1. Today's Appointments (for Check-In)
        $todaysAppointments = Appointment::whereDate('appointment_date', today())
            ->with(['patient', 'doctor', 'queue'])
            ->orderBy('appointment_date')
            ->get();

        // 2. Active Queues (Monitoring)
        $activeQueues = Queue::whereIn('status', ['waiting', 'waiting_screening', 'screening_completed', 'in_consultation', 'waiting_pharmacy', 'waiting_payment', 'called'])
            ->with(['patient', 'appointment.doctor'])
            ->orderBy('created_at')
            ->get();

        // 3. Doctor Schedules (Read Only)
        $schedules = \App\Models\Schedule::with('doctor')
            ->where('is_available', true)
            ->orderByRaw("FIELD(day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
            ->orderBy('start_time')
            ->get();

        return view('dashboards.front_office', compact(
            'totalPatients',
            'todayAppointmentsCount',
            'pendingPaymentCount',
            'todaysAppointments',
            'activeQueues',
            'patients',
            'doctors',
            'schedules'
        ));
    }

    private function getPharmacistDashboard($user)
    {
        // Common Stats
        $totalPatients = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $activeQueues = Queue::whereIn('status', ['waiting', 'waiting_screening', 'screening_completed', 'in_consultation', 'waiting_pharmacy', 'waiting_payment', 'called'])->count();

        // Pharmacist Data
        $pharmacyQueues = Queue::where('status', 'waiting_pharmacy')
            ->with(['patient', 'appointment.medicalRecord'])
            ->orderBy('updated_at')
            ->take(10)
            ->get();

        $lowStockMedicines = \App\Models\Medicine::whereColumn('stock', '<=', 'min_stock')
            ->take(5)
            ->get();

        // Charts Data
        $visitLabels = collect();
        $visitData = collect();
        $appointmentLabels = collect();
        $appointmentData = collect();
        
        $monthlyVisits = MedicalRecord::selectRaw('MONTH(visit_date) as month, COUNT(*) as count')
            ->whereYear('visit_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($monthlyVisits as $visit) {
            $visitLabels->push($months[$visit->month - 1]);
            $visitData->push($visit->count);
        }

        $appointmentStats = Appointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        foreach ($appointmentStats as $stat) {
            $appointmentLabels->push(ucfirst(str_replace('_', ' ', $stat->status)));
            $appointmentData->push($stat->count);
        }

        return view('dashboards.pharmacist', compact(
            'totalPatients',
            'todayAppointments',
            'activeQueues',
            'pharmacyQueues',
            'lowStockMedicines',
            'visitLabels',
            'visitData',
            'appointmentLabels',
            'appointmentData'
        ));
    }

    private function getAdminDashboard($user)
    {
        // Common Data
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalRecords = MedicalRecord::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $activeQueues = Queue::whereIn('status', ['waiting', 'waiting_screening', 'screening_completed', 'in_consultation', 'waiting_pharmacy', 'waiting_payment', 'called'])->count();
        
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $pendingRevenue = Invoice::where('status', 'unpaid')->sum('total_amount');

        // Admin Specific
        $recentRecords = MedicalRecord::with(['patient', 'doctor'])->latest()->take(5)->get();
        
        $todayShifts = \App\Models\Schedule::where('day_of_week', strtolower(now()->format('l')))
            ->where('is_available', true)
            ->with('doctor')
            ->orderBy('start_time')
            ->get();

        // Charts
        $visitLabels = collect();
        $visitData = collect();
        $monthlyVisits = MedicalRecord::selectRaw('MONTH(visit_date) as month, COUNT(*) as count')
            ->whereYear('visit_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($monthlyVisits as $visit) {
            $visitLabels->push($months[$visit->month - 1]);
            $visitData->push($visit->count);
        }

        $appointmentLabels = collect();
        $appointmentData = collect();
        $appointmentStats = Appointment::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        foreach ($appointmentStats as $stat) {
            $appointmentLabels->push(ucfirst(str_replace('_', ' ', $stat->status)));
            $appointmentData->push($stat->count);
        }

        $diagnosisLabels = collect();
        $diagnosisData = collect();

        return view('dashboards.admin', compact(
            'totalPatients',
            'totalDoctors',
            'totalRecords',
            'todayAppointments',
            'activeQueues',
            'totalRevenue',
            'pendingRevenue',
            'recentRecords',
            'todayShifts',
            'visitLabels',
            'visitData',
            'appointmentLabels',
            'appointmentData',
            'diagnosisLabels',
            'diagnosisData'
        ));
    }
}
