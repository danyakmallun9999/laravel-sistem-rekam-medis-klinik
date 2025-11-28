<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Patient -->
                        <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                            <select id="patient_id" name="patient_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select a patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
                            <select id="doctor_id" name="doctor_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select a doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} ({{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <!-- Date & Time -->
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date & Time</label>
                            <input type="datetime-local" name="appointment_date" id="appointment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('appointment_date') }}" required>
                            <x-input-error :messages="$errors->get('appointment_date')" class="mt-2" />
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes') }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('appointments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Schedule Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
