<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Welcome back, {{ $patient->name }}!</h3>
                    <p class="text-gray-600 mt-1">Here is an overview of your health records and appointments.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upcoming Appointments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Upcoming Appointments</h3>
                            <a href="{{ route('patient.appointments') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
                        </div>
                        @if($upcomingAppointments->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($upcomingAppointments as $appointment)
                                    <li class="py-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $appointment->doctor->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $appointment->appointment_date->format('d M Y, H:i') }}</p>
                                            </div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No upcoming appointments.</p>
                            <div class="mt-4">
                                <a href="{{ route('appointments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Book Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Medical Records -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Recent Medical Records</h3>
                            <a href="{{ route('patient.records') }}" class="text-sm text-indigo-600 hover:text-indigo-900">View All</a>
                        </div>
                        @if($recentRecords->count() > 0)
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentRecords as $record)
                                    <li class="py-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $record->diagnosis }}</p>
                                                <p class="text-xs text-gray-500">{{ $record->visit_date->format('d M Y') }} - {{ $record->doctor->name }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No medical records found.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Unpaid Invoices Alert -->
            @if($unpaidInvoices->count() > 0)
                <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                You have {{ $unpaidInvoices->count() }} unpaid invoice(s). 
                                <a href="{{ route('patient.invoices') }}" class="font-medium underline hover:text-red-600">View Invoices</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
