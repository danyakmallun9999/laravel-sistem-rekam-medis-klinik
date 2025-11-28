<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Profile') }}
        </h2>
    </x-slot>

    <!-- Unified Profile Header -->
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
        <div class="p-6 sm:p-8 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white">
            <div class="mb-6">
                <a href="{{ route('patients.index') }}" class="inline-flex items-center text-indigo-100 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Patients
                </a>
            </div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="h-24 w-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl border-4 border-white/30">
                        {{ substr($patient->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">{{ $patient->name }}</h1>
                        <div class="flex items-center gap-4 mt-2 text-indigo-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                {{ $patient->nik }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($patient->dob)->age }} Years Old
                            </span>
                            <span class="flex items-center gap-1 capitalize">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $patient->gender }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4 w-full md:w-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 flex-1 md:flex-none text-center min-w-[120px]">
                        <p class="text-indigo-100 text-sm">Total Visits</p>
                        <p class="text-2xl font-bold">{{ $patient->medicalRecords->count() }}</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 flex-1 md:flex-none text-center min-w-[120px]">
                        <p class="text-indigo-100 text-sm">Last Visit</p>
                        <p class="text-xl font-bold">{{ $patient->medicalRecords->sortByDesc('visit_date')->first()?->visit_date->format('d M Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Info Bar -->
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                {{ $patient->phone }}
            </div>
            <div class="flex items-center gap-2 text-gray-600">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $patient->address }}
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('patients.edit', $patient) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Edit Profile</a>
                <span class="text-gray-300">|</span>
                <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                </form>
            </div>
        </div>

        <!-- Medical Info & Charts -->
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Medical Background -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-red-50 rounded-xl p-5 border border-red-100">
                        <h3 class="text-red-800 font-bold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Allergies
                        </h3>
                        <p class="text-red-700 text-sm">{{ $patient->allergies ?: 'No known allergies' }}</p>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                        <h3 class="text-indigo-800 font-bold mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Medical History
                        </h3>
                        <p class="text-indigo-700 text-sm">{{ $patient->medical_history ?: 'No medical history recorded' }}</p>
                    </div>
                </div>

                <!-- Vital Signs Chart -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 p-4 h-full">
                        <h3 class="font-bold text-gray-900 mb-4">Vital Signs Trends</h3>
                        <canvas id="vitalSignsChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('vitalSignsChart').getContext('2d');
            
            // Prepare Data
            const records = @json($patient->medicalRecords->sortBy('visit_date')->values());
            const labels = records.map(r => new Date(r.visit_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' }));
            
            const systolicData = records.map(r => r.vital_signs?.systolic || null);
            const diastolicData = records.map(r => r.vital_signs?.diastolic || null);
            const weightData = records.map(r => r.vital_signs?.weight || null);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Systolic BP (mmHg)',
                            data: systolicData,
                            borderColor: 'rgb(239, 68, 68)', // Red
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Diastolic BP (mmHg)',
                            data: diastolicData,
                            borderColor: 'rgb(249, 115, 22)', // Orange
                            backgroundColor: 'rgba(249, 115, 22, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Weight (kg)',
                            data: weightData,
                            borderColor: 'rgb(99, 102, 241)', // Indigo
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            tension: 0.3,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Blood Pressure' }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: { display: true, text: 'Weight (kg)' },
                            grid: {
                                drawOnChartArea: false,
                            },
                        },
                    }
                }
            });
        });
    </script>

    <!-- Main Content Tabs -->
    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden min-h-[500px]" x-data="{ tab: 'medical_records' }">
        <div class="border-b border-gray-200">
            <nav class="flex px-6" aria-label="Tabs">
                <button @click="tab = 'medical_records'" 
                    :class="{ 'border-indigo-500 text-indigo-600': tab === 'medical_records', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'medical_records' }"
                    class="py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Medical History
                </button>
                <button @click="tab = 'appointments'" 
                    :class="{ 'border-indigo-500 text-indigo-600': tab === 'appointments', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'appointments' }"
                    class="py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Appointments
                </button>
            </nav>
        </div>

        <!-- Medical Records Tab -->
        <div x-show="tab === 'medical_records'" class="p-6">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold text-gray-900">Patient Timeline</h3>
                <a href="{{ route('medical_records.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Record
                </a>
            </div>
            
            @if($patient->medicalRecords->count() > 0)
                <div class="relative border-l-2 border-indigo-100 ml-3 space-y-8 pb-8">
                    @foreach($patient->medicalRecords->sortByDesc('visit_date') as $record)
                        <div class="relative pl-8 group">
                            <!-- Timeline Dot -->
                            <div class="absolute -left-2.5 top-0 h-5 w-5 rounded-full border-4 border-white bg-indigo-500 shadow-sm group-hover:scale-110 transition-transform"></div>
                            
                            <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $record->diagnosis }}</h4>
                                            <span class="px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                {{ $record->visit_date->format('d M Y') }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Dr. {{ $record->doctor->name }}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('medical_records.show', $record) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors rounded-full hover:bg-gray-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="text-gray-600 mb-4 text-sm leading-relaxed">
                                    <span class="font-medium text-gray-900">Treatment:</span> {{ Str::limit($record->treatment, 200) }}
                                </div>

                                @if($record->vital_signs)
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-50">
                                        @foreach($record->vital_signs as $key => $value)
                                            @if($value)
                                                <div class="bg-gray-50 rounded-lg p-2">
                                                    <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">{{ str_replace('_', ' ', $key) }}</p>
                                                    <p class="font-bold text-gray-900 text-sm">{{ $value }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Medical Records</h3>
                    <p class="text-gray-500 max-w-sm mt-1">This patient hasn't had any medical visits yet. Start by adding a new record.</p>
                    <a href="{{ route('medical_records.create', ['patient_id' => $patient->id]) }}" class="mt-4 text-indigo-600 hover:text-indigo-800 font-medium">Create First Record &rarr;</a>
                </div>
            @endif
        </div>

        <!-- Appointments Tab -->
        <div x-show="tab === 'appointments'" class="p-6" style="display: none;">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-lg font-bold text-gray-900">Appointment History</h3>
                <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Book Appointment
                </a>
            </div>

            @if($patient->appointments->count() > 0)
                <div class="grid gap-4">
                    @foreach($patient->appointments->sortByDesc('appointment_date') as $appointment)
                        <div class="flex items-center justify-between bg-white border border-gray-200 p-5 rounded-xl hover:shadow-md transition-shadow group">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center
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
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <h4 class="font-bold text-gray-900">{{ $appointment->appointment_date->format('d M Y') }}</h4>
                                        <span class="text-gray-400 text-sm">{{ $appointment->appointment_date->format('H:i') }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                            {{ $appointment->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                               ($appointment->status === 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                                            {{ $appointment->status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-1">Dr. {{ $appointment->doctor->name }}</p>
                                    @if($appointment->notes)
                                        <p class="text-sm text-gray-500 italic">"{{ $appointment->notes }}"</p>
                                    @endif
                                </div>
                            </div>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('appointments.edit', $appointment) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition-colors inline-block">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Appointments</h3>
                    <p class="text-gray-500 max-w-sm mt-1">This patient has no past or upcoming appointments.</p>
                    <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="mt-4 text-green-600 hover:text-green-800 font-medium">Book First Appointment &rarr;</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
