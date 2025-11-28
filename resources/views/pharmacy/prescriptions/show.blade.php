<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Process Prescription') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <!-- Patient Info -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Patient Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium">{{ $record->patient->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-medium">{{ $record->patient->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Doctor</p>
                            <p class="font-medium">{{ $record->doctor->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Date</p>
                            <p class="font-medium">{{ $record->visit_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Prescription Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Prescribed Medicines</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Required</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($record->prescriptionItems as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->medicine->name }}</div>
                                            <div class="text-xs text-gray-500">Rp {{ number_format($item->medicine->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->instructions }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->medicine->stock < $item->quantity)
                                                <span class="text-red-600 font-bold">{{ $item->medicine->stock }} (Insufficient)</span>
                                            @else
                                                <span class="text-green-600 font-medium">{{ $item->medicine->stock }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->medicine->stock >= $item->quantity)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ready</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unavailable</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('pharmacy.prescriptions') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Back</a>
                    
                    <form action="{{ route('pharmacy.prescriptions.dispense', $record) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dispense Medicines
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
