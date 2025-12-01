<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pharmacist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
            </div>

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

            <!-- Charts Section -->
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
                            'rgb(245, 158, 11)', // Orange
                            'rgb(107, 114, 128)' // Gray
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
        });
    </script>
</x-app-layout>
