<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Patient Profile') }}
            </h2>

    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('patients.index') }}" class="group inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors mb-4">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $patient->name }}</h1>
                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-full font-medium border border-indigo-100">
                                #{{ $patient->bpjs_number ?? 'NO-BPJS' }}
                            </span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($patient->dob)->format('d M Y') }} ({{ \Carbon\Carbon::parse($patient->dob)->age }} y.o)</span>
                            <span>•</span>
                            <span class="capitalize">{{ $patient->gender }}</span>
                        </div>
                    </div>
                    @can('manage patients')
                    <div class="flex items-center gap-3">
                        <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Profile
                        </a>
                        @if(!$patient->user_id)
                        <form action="{{ route('patients.create-account', $patient) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Create Account
                            </button>
                        </form>
                        @endif
                    </div>
                    @endcan
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Info & Stats -->
                <div class="space-y-6">
                    <!-- Key Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Patient Details</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .883-.393 2-3 2m3 0c.883 0 2 .393 2 3m-8 6h16"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">NIK</p>
                                    <p class="font-medium text-gray-900">{{ $patient->nik }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Blood Type</p>
                                    <p class="font-medium text-gray-900">{{ $patient->blood_type ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Phone</p>
                                    <p class="font-medium text-gray-900">{{ $patient->phone }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Address</p>
                                    <p class="font-medium text-gray-900">{{ $patient->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Overview -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase mb-1">Total Visits</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $patient->medicalRecords->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase mb-1">Last Visit</p>
                            <p class="text-lg font-bold text-gray-900">{{ $patient->medicalRecords->sortByDesc('visit_date')->first()?->visit_date->format('d M Y') ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Allergies & Medical History -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        @if($patient->allergies)
                        <div class="p-4 bg-red-50 border-b border-red-100">
                            <h3 class="text-sm font-bold text-red-900 mb-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Allergies
                            </h3>
                            <p class="text-sm text-red-700">{{ $patient->allergies }}</p>
                        </div>
                        @endif
                        <div class="p-5">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Medical History</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $patient->medical_history ?: 'No medical history recorded.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Tabs & Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Tabs -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ tab: 'medical_records' }">
                        <div class="border-b border-gray-200 px-6">
                            <nav class="-mb-px flex space-x-8">
                                <button @click="tab = 'medical_records'" 
                                    :class="{ 'border-indigo-500 text-indigo-600': tab === 'medical_records', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'medical_records' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                    Medical Records
                                </button>
                                <button @click="tab = 'appointments'" 
                                    :class="{ 'border-indigo-500 text-indigo-600': tab === 'appointments', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'appointments' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                    Appointments
                                </button>
                                <button @click="tab = 'vitals'" 
                                    :class="{ 'border-indigo-500 text-indigo-600': tab === 'vitals', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'vitals' }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center transition-colors">
                                    Vitals Chart
                                </button>
                            </nav>
                        </div>

                        <!-- Medical Records Content -->
                        <div x-show="tab === 'medical_records'" class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-900">Timeline</h3>
                                @unless(auth()->user()->hasRole('front_office'))
                                <a href="{{ route('medical_records.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add Record
                                </a>
                                @endunless
                            </div>

                            @if($patient->medicalRecords->count() > 0)
                                <div class="relative border-l-2 border-indigo-100 ml-3 space-y-8 pb-4">
                                    @foreach($patient->medicalRecords->sortByDesc('visit_date') as $record)
                                        <div class="relative pl-8 group">
                                            <div class="absolute -left-2.5 top-0 h-5 w-5 rounded-full border-4 border-white bg-indigo-500 shadow-sm group-hover:scale-110 transition-transform"></div>
                                            
                                            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow group-hover:border-indigo-100">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900">{{ $record->diagnosis }}</h4>
                                                        <p class="text-sm text-gray-500">
                                                            {{ $record->visit_date->format('d M Y') }} • Dr. {{ $record->doctor->name }}
                                                        </p>
                                                    </div>
                                                    <a href="{{ route('medical_records.show', $record) }}" class="text-gray-400 hover:text-indigo-600 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                </div>
                                                <div class="text-gray-600 text-sm mt-2 line-clamp-2">
                                                    <span class="font-medium">Treatment:</span> {{ $record->treatment }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900">No Medical Records</h3>
                                    <p class="text-sm text-gray-500 mt-1">Start by adding a new medical record.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Appointments Content -->
                        <div x-show="tab === 'appointments'" class="p-6" style="display: none;">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-900">Appointment History</h3>
                                <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Book Appointment
                                </a>
                            </div>

                            @if($patient->appointments->count() > 0)
                                <div class="space-y-4">
                                    @foreach($patient->appointments->sortByDesc('appointment_date') as $appointment)
                                        <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl hover:shadow-md transition-shadow">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center mr-4
                                                {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-600' : 
                                                   ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($appointment->status === 'completed')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    @elseif($appointment->status === 'cancelled')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">{{ $appointment->appointment_date->format('d M Y') }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('H:i') }} • Dr. {{ $appointment->doctor->name }}</p>
                                                    </div>
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                                        {{ $appointment->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                                           ($appointment->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                                        {{ $appointment->status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-medium text-gray-900">No Appointments</h3>
                                    <p class="text-sm text-gray-500 mt-1">No past or upcoming appointments.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Vitals Chart Content -->
                        <div x-show="tab === 'vitals'" class="p-6" style="display: none;">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Vitals Trends</h3>
                            <div class="h-80">
                                <canvas id="vitalSignsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('vitalSignsChart');
            if (!ctx) return;
            
            // Prepare Data
            const records = @json($patient->medicalRecords->sortBy('visit_date')->values());
            const labels = records.map(r => new Date(r.visit_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' }));
            
            const systolicData = records.map(r => r.vital_signs?.systolic || null);
            const diastolicData = records.map(r => r.vital_signs?.diastolic || null);
            const weightData = records.map(r => r.vital_signs?.weight || null);

            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Systolic',
                            data: systolicData,
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Diastolic',
                            data: diastolicData,
                            borderColor: 'rgb(249, 115, 22)',
                            backgroundColor: 'rgba(249, 115, 22, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Weight',
                            data: weightData,
                            borderColor: 'rgb(99, 102, 241)',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true } } },
                    scales: {
                        y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'BP (mmHg)' } },
                        y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'Weight (kg)' }, grid: { drawOnChartArea: false } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });

        function confirmDelete(event, formId) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this patient? This action cannot be undone.')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
</x-app-layout>
