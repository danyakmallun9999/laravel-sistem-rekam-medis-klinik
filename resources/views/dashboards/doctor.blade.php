<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Today's Appointments -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Today's Appointments</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $todayAppointments }}</p>
                        </div>
                    </div>
                </div>

                <!-- Patients Waiting (Screening Completed) -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-50 text-yellow-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Ready for Consultation</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $patientsWaiting ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Patients Finished -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-50 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Finished Today</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $patientsFinished ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Greeting & Schedule Section -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h2>
                                <p class="text-gray-600 mt-1">Have a great day at work!</p>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-4 w-full md:w-auto">
                                <h3 class="font-semibold text-indigo-700 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Your Weekly Schedule
                                </h3>
                                <div class="space-y-2">
                                    @if(isset($doctorSchedules) && $doctorSchedules->count() > 0)
                                        @foreach($doctorSchedules as $schedule)
                                            <div class="flex justify-between text-sm">
                                                <span class="font-medium text-gray-700 w-24 capitalize">{{ $schedule->day_of_week }}</span>
                                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500 italic">No schedule set.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Active Patient Card -->
                <div class="lg:col-span-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-lg text-white overflow-hidden relative">
                    <div class="p-6 relative z-10">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold opacity-90">Current Patient</h3>
                                @if(isset($activePatients) && $activePatients->count() > 0)
                                    @php $currentPatient = $activePatients->first(); @endphp
                                    <h2 class="text-3xl font-bold mt-2">{{ $currentPatient->patient->name }}</h2>
                                    <p class="opacity-75 mt-1">{{ $currentPatient->patient->nik }} • {{ $currentPatient->patient->gender == 'male' ? 'Male' : 'Female' }}</p>
                                    
                                    @if($currentPatient->medicalRecord && $currentPatient->medicalRecord->vital_signs)
                                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 bg-white bg-opacity-10 rounded-lg p-3">
                                            <div>
                                                <span class="block text-xs opacity-75 uppercase">BP</span>
                                                <span class="font-bold">{{ $currentPatient->medicalRecord->vital_signs['blood_pressure'] ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-xs opacity-75 uppercase">Temp</span>
                                                <span class="font-bold">{{ $currentPatient->medicalRecord->vital_signs['temperature'] ?? '-' }}°C</span>
                                            </div>
                                            <div>
                                                <span class="block text-xs opacity-75 uppercase">Weight</span>
                                                <span class="font-bold">{{ $currentPatient->medicalRecord->vital_signs['weight'] ?? '-' }}kg</span>
                                            </div>
                                            <div>
                                                <span class="block text-xs opacity-75 uppercase">Pulse</span>
                                                <span class="font-bold">{{ $currentPatient->medicalRecord->vital_signs['pulse'] ?? '-' }}bpm</span>
                                            </div>
                                        </div>
                                        @if(isset($currentPatient->medicalRecord->soap_data['subjective']))
                                            <div class="mt-2 text-sm bg-white bg-opacity-10 rounded-lg p-3">
                                                <span class="font-bold opacity-75 mr-2">Complaint:</span>
                                                <span class="italic">"{{ $currentPatient->medicalRecord->soap_data['subjective'] }}"</span>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="mt-6 flex space-x-3">
                                        @if($currentPatient->medicalRecord)
                                            <a href="{{ route('medical_records.edit', $currentPatient->medicalRecord->id) }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit Medical Record
                                            </a>
                                        @else
                                            <a href="{{ route('medical_records.create', ['patient_id' => $currentPatient->patient_id, 'appointment_id' => $currentPatient->id]) }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Create Medical Record
                                            </a>
                                        @endif
                                        <form action="{{ route('flow.update-status', $currentPatient) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="waiting_pharmacy">
                                            <button type="submit" class="bg-indigo-700 bg-opacity-50 text-white px-4 py-2 rounded-lg font-semibold hover:bg-opacity-75 transition-colors border border-indigo-400">
                                                Finish Consultation
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <h2 class="text-2xl font-bold mt-2">No Active Patient</h2>
                                    <p class="opacity-75 mt-1">Select a patient from the waiting list to start consultation.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('flow.consultation') }}" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg font-semibold hover:bg-opacity-30 transition-colors inline-flex items-center">
                                            View Queue
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative circles -->
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white opacity-10"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-white opacity-10"></div>
                </div>

                <!-- Waiting List Widget -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900">Ready for Consultation</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ $waitingPatients->count() }} Waiting
                        </span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @if(isset($waitingPatients) && $waitingPatients->count() > 0)
                                    @foreach($waitingPatients as $patient)
                                        <div x-data="{ open: false }" class="border-b border-gray-100 last:border-0">
                                            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group cursor-pointer" @click="open = !open">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold mr-3">
                                                        {{ substr($patient->patient->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $patient->patient->name }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ \Carbon\Carbon::parse($patient->appointment_date)->format('H:i') }}
                                                            @if($patient->medicalRecord && $patient->medicalRecord->soap_data)
                                                                • <span class="italic">"{{ Str::limit($patient->medicalRecord->soap_data['subjective'] ?? '', 20) }}"</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <form action="{{ route('flow.update-status', $patient) }}" method="POST" @click.stop>
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="in_consultation">
                                                    <button type="submit" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition-colors shadow-sm">
                                                        Call Patient
                                                    </button>
                                                </form>
                                            </div>
                                            <!-- Screening Details (Expandable) -->
                                            <div x-show="open" class="px-4 pb-4 bg-gray-50 text-sm text-gray-600 space-y-2">
                                                @if($patient->medicalRecord && $patient->medicalRecord->vital_signs)
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <span class="font-semibold text-xs text-gray-500 uppercase">Blood Pressure</span>
                                                            <p>{{ $patient->medicalRecord->vital_signs['blood_pressure'] ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="font-semibold text-xs text-gray-500 uppercase">Temperature</span>
                                                            <p>{{ $patient->medicalRecord->vital_signs['temperature'] ?? '-' }} °C</p>
                                                        </div>
                                                        <div>
                                                            <span class="font-semibold text-xs text-gray-500 uppercase">Weight</span>
                                                            <p>{{ $patient->medicalRecord->vital_signs['weight'] ?? '-' }} kg</p>
                                                        </div>
                                                        <div>
                                                            <span class="font-semibold text-xs text-gray-500 uppercase">Pulse</span>
                                                            <p>{{ $patient->medicalRecord->vital_signs['pulse'] ?? '-' }} bpm</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <span class="font-semibold text-xs text-gray-500 uppercase">Chief Complaint</span>
                                                        <p class="italic">"{{ $patient->medicalRecord->soap_data['subjective'] ?? '-' }}"</p>
                                                    </div>
                                                @else
                                                    <p class="text-xs italic text-gray-500">No screening data available.</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                        @else
                            <div class="p-8 text-center text-gray-500 text-sm">
                                No patients ready for consultation.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Medical Records Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Medical Records</h3>
                    <a href="{{ route('medical_records.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View All Records &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Complaint</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentMedicalRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($record->visit_date)->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $record->patient->name }}</div>
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $record->patient->nik }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ Str::limit($record->soap_data['subjective'] ?? '-', 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('medical_records.show', $record->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No medical records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Patients Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recently Registered Patients</h3>
                    <a href="{{ route('patients.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View All Patients &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentPatients as $patient)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $patient->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $patient->nik }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ucfirst($patient->gender) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('patients.show', $patient->id) }}" class="text-indigo-600 hover:text-indigo-900">View History</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No patients found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
