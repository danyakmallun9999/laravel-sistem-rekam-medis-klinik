<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Invoice;
use App\Models\Appointment;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Common Data
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalRecords = MedicalRecord::count();
        
        // Initialize variables
        $recentRecords = collect();
        $monthlyVisits = collect();
        $visitLabels = collect();
        $visitData = collect();
        $topDiagnoses = collect();
        $diagnosisLabels = collect();
        $diagnosisData = collect();
        $totalRevenue = 0;
        $pendingRevenue = 0;
        $todayAppointments = 0;
        $activeQueues = 0;
        $appointmentStats = collect();
        $appointmentLabels = collect();
        $appointmentData = collect();

        if ($user->hasRole('admin')) {
            // Admin sees everything
            $recentRecords = MedicalRecord::with(['patient', 'doctor'])->latest()->take(5)->get();
            
            $monthlyVisits = MedicalRecord::select(
                DB::raw('COUNT(id) as count'), 
                DB::raw('DATE_FORMAT(visit_date, "%Y-%m") as month_year'),
                DB::raw('DATE_FORMAT(visit_date, "%M") as month_name')
            )
            ->where('visit_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month_year', 'month_name')
            ->orderBy('month_year')
            ->get();

            $visitLabels = $monthlyVisits->pluck('month_name');
            $visitData = $monthlyVisits->pluck('count');

            $topDiagnoses = MedicalRecord::select('diagnosis', DB::raw('count(*) as total'))
                ->groupBy('diagnosis')
                ->orderByDesc('total')
                ->take(5)
                ->get();

            $diagnosisLabels = $topDiagnoses->pluck('diagnosis');
            $diagnosisData = $topDiagnoses->pluck('total');

            $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
            $pendingRevenue = Invoice::where('status', 'unpaid')->sum('total_amount');

            $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
            $activeQueues = Queue::whereIn('status', ['waiting', 'called'])->whereDate('created_at', today())->count();

            $appointmentStats = Appointment::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get();
            
            $appointmentLabels = $appointmentStats->pluck('status');
            $appointmentData = $appointmentStats->pluck('total');

        } elseif ($user->hasRole('doctor')) {
            // Doctor sees their own data
            $doctor = Doctor::where('email', $user->email)->first();
            
            if ($doctor) {
                $recentRecords = MedicalRecord::where('doctor_id', $doctor->id)->with(['patient'])->latest()->take(5)->get();
                $todayAppointments = Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count();
                
                // Doctor specific charts could be added here
            }
        }

        return view('dashboard', compact(
            'totalPatients', 
            'totalDoctors', 
            'totalRecords', 
            'recentRecords',
            'visitLabels',
            'visitData',
            'diagnosisLabels',
            'diagnosisData',
            'totalRevenue',
            'pendingRevenue',
            'todayAppointments',
            'activeQueues',
            'appointmentLabels',
            'appointmentData'
        ));
    }
}
