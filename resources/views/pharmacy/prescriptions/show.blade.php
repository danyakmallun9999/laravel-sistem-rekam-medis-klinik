<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Process Prescription') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <!-- Unified Header -->
    <div class="max-w-5xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6">
            <div class="p-6 sm:p-8 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white">
                <div class="mb-6">
                    <a href="{{ route('pharmacy.prescriptions') }}" class="inline-flex items-center text-indigo-100 hover:text-white transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Prescriptions
                    </a>
                </div>
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-bold">Prescription Details</h1>
                        <div class="flex items-center gap-6 mt-2 text-indigo-100">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $record->visit_date->format('d F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient & Doctor Info Bar -->
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                        {{ substr($record->patient->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Patient</p>
                        <p class="font-bold text-gray-900">{{ $record->patient->name }} <span class="text-gray-400 font-normal">({{ $record->patient->nik }})</span></p>
                    </div>
                </div>
                <div class="flex items-center gap-4 md:justify-end">
                    <div class="text-right hidden md:block">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Prescribed By</p>
                        <p class="font-bold text-gray-900">{{ $record->doctor->name }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                        {{ substr($record->doctor->name, 0, 1) }}
                    </div>
                    <div class="md:hidden">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Prescribed By</p>
                        <p class="font-bold text-gray-900">{{ $record->doctor->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescription Items -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden p-6 sm:p-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Prescribed Medicines
            </h3>
            
            <div class="overflow-hidden border border-gray-200 rounded-xl mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($record->prescriptionItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->medicine->name }}</div>
                                    <div class="text-xs text-gray-500">Rp {{ number_format($item->medicine->price, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $item->instructions ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->medicine->stock < $item->quantity)
                                        <span class="text-red-600 font-bold flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            {{ $item->medicine->stock }} (Insufficient)
                                        </span>
                                    @else
                                        <span class="text-green-600 font-medium">{{ $item->medicine->stock }} in stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->medicine->stock >= $item->quantity)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            Ready
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            Unavailable
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Actions -->
            <div class="flex justify-end pt-6 border-t border-gray-100">
                @if($record->appointment && $record->appointment->status == 'waiting_pharmacy')
                    <form action="{{ route('pharmacy.prescriptions.dispense', $record) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dispense Medicines
                        </button>
                    </form>
                @else
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 border border-green-200 rounded-lg font-semibold text-green-800 uppercase tracking-widest shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Medicines Dispensed
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
