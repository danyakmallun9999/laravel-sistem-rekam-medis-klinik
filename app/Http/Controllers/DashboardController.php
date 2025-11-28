<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalRecords = MedicalRecord::count();

        // Recent Activity
        $recentRecords = MedicalRecord::with(['patient', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        // Chart 1: Monthly Visits (Last 6 Months)
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

        // Chart 2: Top 5 Diagnoses
        $topDiagnoses = MedicalRecord::select('diagnosis', DB::raw('count(*) as total'))
            ->groupBy('diagnosis')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $diagnosisLabels = $topDiagnoses->pluck('diagnosis');
        $diagnosisData = $topDiagnoses->pluck('total');

        return view('dashboard', compact(
            'totalPatients', 
            'totalDoctors', 
            'totalRecords', 
            'recentRecords',
            'visitLabels',
            'visitData',
            'diagnosisLabels',
            'diagnosisData'
        ));
    }
}
