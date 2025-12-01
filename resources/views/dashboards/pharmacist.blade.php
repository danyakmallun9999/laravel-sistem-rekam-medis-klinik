<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pharmacist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pending Prescriptions -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Pending Prescriptions</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $pendingPrescriptionsCount }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('flow.pharmacy') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                            Process Queue <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Low Stock Alerts -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Low Stock Items</p>
                            <p class="text-3xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $lowStockCount }}</p>
                        </div>
                        <div class="p-3 rounded-full {{ $lowStockCount > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pharmacy.inventory') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                            Check Inventory <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Total Medicines -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Medicines</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalMedicines }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('pharmacy.inventory.create') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                            Add New Medicine <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Prescription Queue (Left - Wider) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Prescription Queue</h3>
                                <p class="text-sm text-gray-500">Patients waiting for medication</p>
                            </div>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                {{ $pendingPrescriptionsCount }} Pending
                            </span>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($pharmacyQueues as $queue)
                                <div class="p-6 hover:bg-gray-50 transition-colors group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg shadow-sm">
                                                {{ $queue->queue_number }}
                                            </div>
                                            <div>
                                                <h4 class="text-base font-semibold text-gray-900">{{ $queue->patient->name }}</h4>
                                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Waiting since {{ $queue->updated_at->format('H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('pharmacy.prescriptions.show', ['record' => $queue->appointment->medicalRecord->id ?? 0]) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                                Dispense
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div class="mx-auto h-16 w-16 bg-green-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">All Caught Up!</h3>
                                    <p class="text-gray-500 mt-1">No pending prescriptions at the moment.</p>
                                </div>
                            @endforelse
                        </div>
                        @if($pharmacyQueues->count() > 0)
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                                <a href="{{ route('flow.pharmacy') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 flex items-center justify-center">
                                    View All Queue <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-8">
                    <!-- Low Stock Widget -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-5 border-b border-gray-100 bg-red-50 flex justify-between items-center">
                            <h3 class="font-bold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Critical Stock
                            </h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse($lowStockMedicines as $medicine)
                                <div class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-sm font-bold text-gray-900">{{ $medicine->name }}</h4>
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">
                                            {{ $medicine->stock }} left
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">Min: {{ $medicine->min_stock }}</span>
                                        <a href="{{ route('pharmacy.inventory.edit', $medicine) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-900">
                                            Restock &rarr;
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center">
                                    <p class="text-sm text-gray-500">No critical stock alerts.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-6 text-white">
                        <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('pharmacy.inventory.create') }}" class="block w-full py-2.5 px-4 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Add New Medicine
                            </a>
                            <a href="{{ route('pharmacy.prescriptions') }}" class="block w-full py-2.5 px-4 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                View All Prescriptions
                            </a>
                            <a href="{{ route('pharmacy.inventory') }}" class="block w-full py-2.5 px-4 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold transition-colors flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                Manage Inventory
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
