<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Front Office Dashboard') }}
        </h2>
    </x-slot>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px;
            border-color: #d1d5db;
            border-radius: 0.5rem; /* Rounded-lg to match Tailwind */
            padding-top: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
        }
        /* Custom Scrollbar for Tabs */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 flex items-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Patients</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPatients }}</p>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 flex items-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Appointments Today</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $todayAppointmentsCount }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 flex items-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-3 rounded-full bg-red-50 text-red-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending Payments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingPaymentCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Action Center (Priority - Wider) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Quick Walk-in Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden relative border-t-4 border-t-indigo-600">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600 mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Quick Walk-in</h3>
                                    <p class="text-sm text-gray-500">Register new patient</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('queues.store') }}" method="POST" class="space-y-5">
                                @csrf
                                <!-- Patient -->
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Select Patient</label>
                                    <select id="patient_id" name="patient_id" class="w-full text-gray-900 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                        <option value="">Search by name or NIK...</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->nik }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Poli -->
                                    <div>
                                        <label for="poli" class="block text-sm font-medium text-gray-700 mb-1">Polyclinic</label>
                                        <select id="poli" name="poli" class="w-full text-gray-900 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                            <option value="General">General Practitioner</option>
                                            <option value="Dental">Dental Clinic</option>
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="Pediatrics">Pediatrics</option>
                                        </select>
                                    </div>

                                    <!-- Doctor -->
                                    <div>
                                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Assign Doctor</label>
                                        <select id="doctor_id" name="doctor_id" class="w-full text-gray-900 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                            <option value="">Select Doctor</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialization }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm flex justify-center items-center">
                                    <span>Register & Print Number</span>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pending Payments (Cashier) -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden border-t-4 border-t-green-500">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-bold text-gray-900">Pending Payments</h3>
                                <span class="text-xs font-medium text-gray-500 bg-white border border-gray-200 px-2 py-1 rounded-md">{{ $pendingPayments->count() }} Waiting</span>
                            </div>
                            <div class="divide-y divide-gray-100 max-h-[300px] overflow-y-auto">
                                @forelse($pendingPayments as $payment)
                                    <div class="p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-gray-900 text-sm">{{ $payment->patient->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $payment->doctor->name }}</p>
                                            </div>
                                            <a href="{{ route('invoices.create', ['appointment_id' => $payment->id]) }}" class="text-xs bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-md hover:bg-green-100 font-semibold transition-colors">
                                                Process
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-gray-500 text-sm">
                                        No pending payments.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Scheduled Appointments (Secondary) -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="font-bold text-gray-900">Scheduled Appointments</h3>
                                <span class="text-xs font-medium text-gray-500 bg-white border border-gray-200 px-2 py-1 rounded-md">Today</span>
                            </div>
                            <div class="divide-y divide-gray-100 max-h-[300px] overflow-y-auto">
                                @forelse($todaysAppointments as $appointment)
                                    <div class="p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-semibold text-gray-900 text-sm">{{ $appointment->patient->name }}</p>
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }} • {{ $appointment->doctor->name }}</p>
                                            </div>
                                            @if($appointment->status == 'scheduled')
                                                <form action="{{ route('queues.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                                                    <button type="submit" class="text-xs bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-md hover:bg-green-100 font-semibold transition-colors">
                                                        Check In
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded border border-gray-200">{{ ucfirst($appointment->status) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-gray-500 text-sm">
                                        No scheduled appointments.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Monitoring (Narrower) -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Live Queue Monitor -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[500px]">
                        <div class="p-4 border-b border-gray-100 bg-white flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-gray-900">Live Monitor</h3>
                            </div>
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-full text-xs font-semibold flex items-center">
                                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-1.5 animate-pulse"></span>
                                {{ $activeQueues->count() }}
                            </span>
                        </div>
                        <div class="divide-y divide-gray-100 overflow-y-auto flex-1 p-0">
                            @forelse($activeQueues as $queue)
                                <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-700 font-bold text-sm mr-3 border border-gray-200 group-hover:border-indigo-200 group-hover:bg-indigo-50 group-hover:text-indigo-700 transition-colors">
                                            {{ $queue->number }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm truncate w-24">{{ $queue->patient->name }}</p>
                                            <p class="text-xs text-gray-500 flex items-center mt-0.5">
                                                <span class="bg-white border border-gray-200 text-gray-600 text-[10px] px-1.5 py-0.5 rounded mr-1 font-medium">{{ substr($queue->poli, 0, 3) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $statusColors = [
                                                'waiting' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'waiting_screening' => 'bg-orange-50 text-orange-700 border-orange-200',
                                                'screening_completed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'in_consultation' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'waiting_pharmacy' => 'bg-teal-50 text-teal-700 border-teal-200',
                                                'waiting_payment' => 'bg-green-50 text-green-700 border-green-200',
                                            ];
                                            $color = $statusColors[$queue->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $color }} border block mb-1">
                                            {{ ucfirst(str_replace('_', ' ', $queue->status)) }}
                                        </span>
                                        
                                        <!-- Quick Actions -->
                                        @if($queue->status == 'waiting')
                                            <form action="{{ route('flow.update-status', $queue->appointment_id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="waiting_screening">
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium" title="Send to Screening">
                                                    Screening &rarr;
                                                </button>
                                            </form>
                                        @elseif($queue->status == 'waiting_payment')
                                            <a href="{{ route('invoices.create', ['appointment_id' => $queue->appointment_id]) }}" class="text-green-600 hover:text-green-800 text-xs font-medium" title="Process Payment">
                                                Pay &rarr;
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <p class="text-sm font-medium text-gray-900">No active queues</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Doctor Schedules (Tabbed) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ activeDay: '{{ strtolower(now()->format('l')) }}' }">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900">Doctor Schedules</h3>
                        </div>
                        
                        <!-- Tabs -->
                        <div class="flex overflow-x-auto border-b border-gray-100 no-scrollbar bg-white">
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <button 
                                    @click="activeDay = '{{ $day }}'"
                                    :class="{ 'border-indigo-500 text-indigo-600 bg-indigo-50': activeDay === '{{ $day }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeDay !== '{{ $day }}' }"
                                    class="flex-shrink-0 px-3 py-2 border-b-2 font-medium text-xs transition-colors focus:outline-none capitalize">
                                    {{ substr($day, 0, 3) }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Content -->
                        <div class="max-h-[300px] overflow-y-auto p-4 bg-white">
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <div x-show="activeDay === '{{ $day }}'">
                                    @php
                                        $daySchedules = $schedules->where('day_of_week', $day);
                                    @endphp
                                    
                                    @if($daySchedules->count() > 0)
                                        <div class="space-y-3">
                                            @foreach($daySchedules as $schedule)
                                                <div class="flex items-center p-2 rounded-lg border border-gray-100">
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3 flex-shrink-0 text-xs">
                                                        {{ substr($schedule->doctor->name, 0, 1) }}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-xs font-medium text-gray-900 truncate">
                                                            {{ $schedule->doctor->name }}
                                                        </p>
                                                        <p class="text-[10px] text-gray-500 truncate">
                                                            {{ $schedule->doctor->specialization }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right flex-shrink-0">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <p class="text-xs text-gray-500">No doctors scheduled.</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links Footer -->
            <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-6">
                {{-- Register New Patient button removed as per user request (confused with Add Medical Record?) --}}
                <a href="{{ route('patients.index') }}" class="block p-5 bg-white border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all text-center group">
                    <div class="text-gray-400 group-hover:text-indigo-600 mb-2 transition-colors">
                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="block font-semibold text-gray-900 group-hover:text-indigo-600">Patient Database</span>
                </a>
                <a href="{{ route('schedules.index') }}" class="block p-5 bg-white border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all text-center group">
                    <div class="text-gray-400 group-hover:text-indigo-600 mb-2 transition-colors">
                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="block font-semibold text-gray-900 group-hover:text-indigo-600">Doctor Schedules</span>
                </a>
                <a href="{{ route('invoices.index') }}" class="block p-5 bg-white border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all text-center group">
                    <div class="text-gray-400 group-hover:text-indigo-600 mb-2 transition-colors">
                        <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <span class="block font-semibold text-gray-900 group-hover:text-indigo-600">Transaction History</span>
                </a>
            </div>

        </div>
    </div>

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#patient_id').select2({
                placeholder: "Search for a patient...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>
