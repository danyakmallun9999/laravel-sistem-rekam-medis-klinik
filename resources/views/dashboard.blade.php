<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @unlessrole('doctor')
                <!-- Total Patients -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Patients</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalPatients }}</p>
                        </div>
                    </div>
                </div>
                @endunlessrole

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

                @role('doctor')
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
                @endrole

                @role('admin')
                <!-- Total Doctors -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-teal-50 text-teal-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Doctors</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalDoctors }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Queues -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Queues</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activeQueues }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-50 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-50 text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending Payments</p>
                            <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @endrole
            </div>

            @role('front_office')
            <!-- Front Office Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Queue Monitor -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden lg:col-span-2">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Registration & Queue
                        </h3>
                        <a href="{{ route('flow.screening') }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-medium">Manage Queues</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($currentQueues as $queue)
                            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-4">
                                        {{ $queue->queue_number }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $queue->patient->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            Status: <span class="capitalize font-semibold {{ $queue->status == 'waiting' ? 'text-yellow-600' : 'text-green-600' }}">{{ str_replace('_', ' ', $queue->status) }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    @if($queue->status == 'waiting')
                                        <form action="{{ route('flow.update-status', $queue->appointment_id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="waiting_screening">
                                            <button type="submit" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition-colors shadow-sm">
                                                Send to Screening
                                            </button>
                                        </form>
                                    @elseif($queue->status == 'waiting_payment')
                                        <a href="{{ route('invoices.create', ['patient_id' => $queue->patient_id]) }}" class="text-xs bg-green-50 text-green-600 px-3 py-1.5 rounded hover:bg-green-100 transition-colors">
                                            Process Payment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 text-sm">
                                No active queues.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Billing & Insurance -->
                <div class="space-y-6">
                    <!-- Unpaid Invoices -->
                    <!-- Unpaid Invoices (Hidden/Removed for cleaner UI) -->
                    <!-- 
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        ...
                    </div> 
                    -->

                    <!-- Insurance Verification Shortcut -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-sm text-white p-4">
                        <h3 class="font-semibold text-lg mb-1">Insurance Check</h3>
                        <p class="text-blue-100 text-xs mb-4">Verify patient insurance status before service.</p>
                        <a href="{{ route('patients.index') }}" class="block text-center w-full bg-white text-blue-600 text-sm font-semibold py-2 rounded-lg hover:bg-blue-50 transition-colors">
                            Find Patient
                        </a>
                    </div>
                </div>
            </div>
            @endrole

            @role('nurse')
            <!-- Nurse Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Screening Queue -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden lg:col-span-2">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Screening Queue (Triage)
                        </h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            {{ $screeningQueues->count() }} Waiting
                        </span>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($screeningQueues as $appointment)
                            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-4">
                                        {{ $appointment->queue->number ?? '-' }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            Registered: {{ $appointment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('screening.create', ['appointment' => $appointment->id]) }}" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition-colors shadow-sm">
                                        Start Screening
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 text-sm">
                                No patients waiting for screening.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Nurse Quick Stats / Info -->
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl shadow-lg text-white p-6">
                        <h3 class="font-semibold text-lg mb-2">Nurse Station</h3>
                        <p class="text-pink-100 text-sm mb-4">Focus on accurate vital signs and chief complaint recording.</p>
                        <div class="bg-white bg-opacity-20 rounded-lg p-3">
                            <p class="text-xs font-medium uppercase tracking-wider opacity-75">Today's Screenings</p>
                            <p class="text-2xl font-bold">{{ \App\Models\Appointment::where('status', 'screening_completed')->whereDate('updated_at', today())->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endrole

            @role('pharmacist')
            <!-- Pharmacist Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Prescription Queue -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden lg:col-span-2">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            Prescription Queue
                        </h3>
                        <a href="{{ route('flow.pharmacy') }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-medium">Manage Prescriptions</a>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($pharmacyQueues as $queue)
                            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-4">
                                        {{ $queue->queue_number }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $queue->patient->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            Status: <span class="capitalize font-semibold text-yellow-600">Waiting for Medicine</span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('pharmacy.prescriptions.show', ['record' => $queue->appointment->medical_record_id]) }}" class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700 transition-colors shadow-sm">
                                        Process
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 text-sm">
                                No prescriptions pending.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Stock Alerts & Info -->
                <div class="space-y-6">
                    <!-- Low Stock Widget -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-semibold text-gray-900 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Low Stock Alerts
                            </h3>
                            <a href="{{ route('pharmacy.inventory') }}" class="text-xs text-indigo-600 hover:text-indigo-900">View Inventory</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($lowStockMedicines as $medicine)
                                <div class="p-3 hover:bg-gray-50 transition-colors flex justify-between items-center">
                                    <div>
                                        <p class="text-xs font-medium text-gray-900">{{ $medicine->name }}</p>
                                        <p class="text-xs text-gray-500">Stock: <span class="font-bold text-red-600">{{ $medicine->stock }}</span></p>
                                    </div>
                                    <a href="{{ route('pharmacy.inventory.edit', $medicine) }}" class="text-xs text-gray-400 hover:text-gray-600">
                                        Restock
                                    </a>
                                </div>
                            @empty
                                <div class="p-4 text-center text-gray-500 text-xs text-green-600">
                                    All stock levels healthy.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-teal-500 to-emerald-500 rounded-xl shadow-lg text-white p-6">
                        <h3 class="font-semibold text-lg mb-2">Pharmacy</h3>
                        <p class="text-teal-100 text-sm mb-4">Ensure accurate dispensing and stock management.</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('pharmacy.inventory.create') }}" class="flex-1 bg-white bg-opacity-20 text-center py-2 rounded-lg text-xs font-semibold hover:bg-opacity-30 transition-colors">
                                Add Medicine
                            </a>
                            <a href="{{ route('pharmacy.prescriptions') }}" class="flex-1 bg-white bg-opacity-20 text-center py-2 rounded-lg text-xs font-semibold hover:bg-opacity-30 transition-colors">
                                All Prescriptions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endrole

            @role('doctor')
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
                                        <a href="{{ route('medical_records.create', ['patient_id' => $currentPatient->patient_id]) }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-50 transition-colors flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Open Medical Record
                                        </a>
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
            @endrole

            <!-- Quick Actions -->
            <!-- Quick Actions -->
            @role('admin|front_office')
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('patients.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Register Patient</p>
                            <p class="text-sm text-gray-500">Add a new patient record</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('appointments.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <div class="p-2 bg-blue-100 rounded-lg text-blue-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Book Appointment</p>
                            <p class="text-sm text-gray-500">Schedule a visit</p>
                        </div>
                    </a>

                    <a href="{{ route('invoices.create') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <div class="p-2 bg-green-100 rounded-lg text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Create Invoice</p>
                            <p class="text-sm text-gray-500">Generate a new bill</p>
                        </div>
                    </a>

                    @role('admin')
                    <a href="{{ route('schedules.index') }}" class="flex items-center p-4 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <div class="p-2 bg-purple-100 rounded-lg text-purple-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Schedules</p>
                            <p class="text-sm text-gray-500">Doctor availability</p>
                        </div>
                    </a>
                    @endrole
                </div>
            </div>
            @endrole

            <!-- Charts Section -->
            @unlessrole('doctor')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Monthly Visits Chart -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 lg:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Patient Visits</h3>
                    <div class="relative h-64">
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>

                <!-- Appointment Status Chart -->
                <div class="bg-white p-6 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Appointment Status</h3>
                    <div class="relative h-64">
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>
            @endunlessrole

            <!-- Today's Shifts -->
            @if(isset($todayShifts) && $todayShifts->count() > 0)
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Today's Shifts ({{ now()->format('l, d M Y') }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($todayShifts as $shift)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                    {{ substr($shift->doctor->name, 4, 1) }}
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $shift->doctor->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $shift->doctor->specialization }}</p>
                                    <div class="mt-1 flex items-center text-xs text-gray-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    @php
                                        $now = now();
                                        $start = \Carbon\Carbon::parse($shift->start_time);
                                        $end = \Carbon\Carbon::parse($shift->end_time);
                                        $isActive = $now->between($start, $end);
                                    @endphp
                                    @if($isActive)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Upcoming
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Doctor</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentRecords as $record)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ $record->visit_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                                    {{ substr($record->patient->name, 0, 1) }}
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">{{ $record->patient->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $record->doctor->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ Str::limit($record->diagnosis, 20) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('medical_records.show', $record) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Visits Chart
            const visitsCtx = document.getElementById('visitsChart').getContext('2d');
            new Chart(visitsCtx, {
                type: 'line',
                data: {
                    labels: @json($visitLabels),
                    datasets: [{
                        label: 'Visits',
                        data: @json($visitData),
                        borderColor: 'rgb(79, 70, 229)',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Top Diagnoses Chart
            const diagnosesCtx = document.getElementById('diagnosesChart');
            if (diagnosesCtx) {
                new Chart(diagnosesCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($diagnosisLabels),
                        datasets: [{
                            data: @json($diagnosisData),
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)',
                                'rgb(139, 92, 246)'
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });
            }

            // Appointment Status Chart
            const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
            new Chart(appointmentsCtx, {
                type: 'pie',
                data: {
                    labels: @json($appointmentLabels),
                    datasets: [{
                        data: @json($appointmentData),
                        backgroundColor: [
                            'rgb(59, 130, 246)', // Blue
                            'rgb(16, 185, 129)', // Green
                            'rgb(239, 68, 68)',  // Red
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
