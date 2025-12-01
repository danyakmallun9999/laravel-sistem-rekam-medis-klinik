<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Screening') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Patient Info & History -->
                <div class="space-y-6">
                    <!-- Patient Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg mr-4">
                                    {{ substr($patient->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $patient->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $patient->nik }}</p>
                                </div>
                            </div>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 text-sm">
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500">Gender</dt>
                                    <dd class="mt-1 text-gray-900 capitalize">{{ $patient->gender }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="font-medium text-gray-500">Date of Birth</dt>
                                    <dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Medical History (Read Only) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical History</h3>
                            <div class="space-y-4">
                                @forelse($previousRecords as $record)
                                    <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($record->visit_date)->format('d M Y') }}</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $record->doctor->name }}</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $record->diagnosis ?? 'No diagnosis' }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500 italic">No previous records found.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Screening Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Initial Screening Input</h3>
                            
                            <form action="{{ route('screening.store', $appointment) }}" method="POST">
                                @csrf
                                
                                <!-- Vital Signs -->
                                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                    <h4 class="font-medium text-gray-700 mb-4">Vital Signs</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <x-input-label for="blood_pressure" :value="__('Blood Pressure (mmHg)')" />
                                            <x-text-input id="blood_pressure" class="block mt-1 w-full" type="text" name="blood_pressure" :value="old('blood_pressure')" required placeholder="e.g. 120/80" />
                                            <x-input-error :messages="$errors->get('blood_pressure')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="temperature" :value="__('Temperature (°C)')" />
                                            <x-text-input id="temperature" class="block mt-1 w-full" type="number" step="0.1" name="temperature" :value="old('temperature')" required placeholder="e.g. 36.5" />
                                            <x-input-error :messages="$errors->get('temperature')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="weight" :value="__('Weight (kg)')" />
                                            <x-text-input id="weight" class="block mt-1 w-full" type="number" step="0.1" name="weight" :value="old('weight')" required placeholder="e.g. 65" />
                                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="pulse" :value="__('Pulse (bpm)')" />
                                            <x-text-input id="pulse" class="block mt-1 w-full" type="number" name="pulse" :value="old('pulse')" placeholder="e.g. 80" />
                                            <x-input-error :messages="$errors->get('pulse')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="respiratory_rate" :value="__('Respiratory Rate (bpm)')" />
                                            <x-text-input id="respiratory_rate" class="block mt-1 w-full" type="number" name="respiratory_rate" :value="old('respiratory_rate')" placeholder="e.g. 18" />
                                            <x-input-error :messages="$errors->get('respiratory_rate')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Chief Complaint -->
                                <div class="mb-6">
                                    <x-input-label for="chief_complaint" :value="__('Chief Complaint (Keluhan Utama)')" />
                                    <textarea id="chief_complaint" name="chief_complaint" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Describe the patient's main complaint...">{{ old('chief_complaint') }}</textarea>
                                    <x-input-error :messages="$errors->get('chief_complaint')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                                    <x-primary-button>
                                        {{ __('Submit Screening') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
