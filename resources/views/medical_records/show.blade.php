<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Record Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $medicalRecord->diagnosis }}</h3>
                    <p class="text-gray-500">{{ $medicalRecord->visit_date }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Completed</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Patient</h4>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                            {{ substr($medicalRecord->patient->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $medicalRecord->patient->name }}</p>
                            <p class="text-sm text-gray-500">{{ $medicalRecord->patient->nik }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Doctor</h4>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold mr-3">
                            {{ substr($medicalRecord->doctor->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $medicalRecord->doctor->name }}</p>
                            <p class="text-sm text-gray-500">{{ $medicalRecord->doctor->specialization }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vital Signs Display -->
            @if($medicalRecord->vital_signs)
            <div class="mb-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">Vital Signs</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($medicalRecord->vital_signs as $key => $value)
                        @if($value)
                        <div>
                            <p class="text-xs text-gray-500 uppercase">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="font-bold text-gray-900">{{ $value }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- SOAP Display -->
            @if($medicalRecord->soap_data)
            <div class="mb-8 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                <h4 class="text-sm font-medium text-indigo-500 uppercase tracking-wider mb-4">SOAP Assessment</h4>
                <div class="space-y-4">
                    @foreach($medicalRecord->soap_data as $key => $value)
                        @if($value)
                        <div>
                            <p class="text-xs text-indigo-500 uppercase font-bold">{{ ucfirst($key) }}</p>
                            <p class="text-gray-800 whitespace-pre-line">{{ $value }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <div class="space-y-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Treatment Summary</h4>
                    <div class="bg-gray-50 p-4 rounded-lg text-gray-700">
                        {{ $medicalRecord->treatment }}
                    </div>
                </div>

                @if($medicalRecord->attachments)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Attachments</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($medicalRecord->attachments as $path)
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="block p-4 border rounded-lg hover:bg-gray-50 transition-colors text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    <span class="text-sm text-indigo-600 truncate block">{{ basename($path) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($medicalRecord->prescriptionItems->count() > 0)
                    <div>
                        <h4 class="text-sm font-medium text-green-600 uppercase tracking-wider mb-2">E-Prescription</h4>
                        <div class="bg-white border border-green-200 rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-green-100">
                                <thead class="bg-green-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Medicine</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Qty</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Instructions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-green-100">
                                    @foreach($medicalRecord->prescriptionItems as $item)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $item->medicine->name }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $item->quantity }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $item->instructions ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($medicalRecord->prescription)
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Prescription (Legacy)</h4>
                        <div class="bg-yellow-50 p-4 rounded-lg text-gray-700 border border-yellow-100">
                            {{ $medicalRecord->prescription }}
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-4">
                <a href="{{ route('medical_records.edit', $medicalRecord) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">Edit Record</a>
                <form action="{{ route('medical_records.destroy', $medicalRecord) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete Record</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
