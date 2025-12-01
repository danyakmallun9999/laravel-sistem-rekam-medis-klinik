<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Walk-in Registration') }}
        </h2>
    </x-slot>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 42px;
            border-color: #d1d5db;
            border-radius: 0.375rem;
            padding-top: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('queues.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Patient (Searchable) -->
                        <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                            <select id="patient_id" name="patient_id" class="mt-1 block w-full" required>
                                <option value="">Select a patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->nik }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                        </div>

                        <!-- Polyclinic / Service -->
                        <div>
                            <label for="poli" class="block text-sm font-medium text-gray-700">Polyclinic / Service</label>
                            <select id="poli" name="poli" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select Service</option>
                                <option value="General" {{ old('poli') == 'General' ? 'selected' : '' }}>General Practitioner</option>
                                <option value="Dental" {{ old('poli') == 'Dental' ? 'selected' : '' }}>Dental Clinic</option>
                                <option value="Cardiology" {{ old('poli') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                <option value="Pediatrics" {{ old('poli') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                            </select>
                            <x-input-error :messages="$errors->get('poli')" class="mt-2" />
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Assign Doctor</label>
                            <select id="doctor_id" name="doctor_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} ({{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Assigning a doctor creates an immediate appointment.</p>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('queues.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Register & Print Number
                            </button>
                        </div>
                    </form>
                </div>
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
