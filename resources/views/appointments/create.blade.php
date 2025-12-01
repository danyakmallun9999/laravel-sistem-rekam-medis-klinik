<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule Appointment') }}
        </h2>
    </x-slot>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom styles to match Tailwind input */
        .select2-container .select2-selection--single {
            height: 42px;
            border-color: #d1d5db; /* gray-300 */
            border-radius: 0.375rem; /* rounded-md */
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
                    <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
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

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Time Slot -->
                        <div>
                            <label for="time_slot" class="block text-sm font-medium text-gray-700">Available Time Slot</label>
                            <select id="time_slot" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" disabled required>
                                <option value="">Select a doctor and date first</option>
                            </select>
                            <!-- Hidden input for the full datetime string expected by backend -->
                            <input type="hidden" name="appointment_date" id="appointment_date">
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

    <!-- jQuery & Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 for Patient
            $('#patient_id').select2({
                placeholder: "Search for a patient...",
                allowClear: true,
                width: '100%'
            });

            const doctorSelect = document.getElementById('doctor_id');
            const dateInput = document.getElementById('date');
            const timeSelect = document.getElementById('time_slot');
            const appointmentDateInput = document.getElementById('appointment_date');

            function fetchSlots() {
                const doctorId = doctorSelect.value;
                const date = dateInput.value;

                if (!doctorId || !date) {
                    timeSelect.innerHTML = '<option value="">Select a doctor and date first</option>';
                    timeSelect.disabled = true;
                    return;
                }

                timeSelect.innerHTML = '<option value="">Loading slots...</option>';
                timeSelect.disabled = true;

                fetch(`{{ route('appointments.slots') }}?doctor_id=${doctorId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        timeSelect.innerHTML = '<option value="">Select a time slot</option>';
                        
                        if (data.slots.length === 0) {
                            const option = document.createElement('option');
                            option.text = "No available slots for this date";
                            timeSelect.appendChild(option);
                        } else {
                            data.slots.forEach(slot => {
                                const option = document.createElement('option');
                                option.value = slot;
                                option.text = slot;
                                timeSelect.appendChild(option);
                            });
                            timeSelect.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching slots:', error);
                        timeSelect.innerHTML = '<option value="">Error loading slots</option>';
                    });
            }

            doctorSelect.addEventListener('change', fetchSlots);
            dateInput.addEventListener('change', fetchSlots);

            timeSelect.addEventListener('change', function() {
                if (this.value && dateInput.value) {
                    // Combine date and time for the backend
                    appointmentDateInput.value = `${dateInput.value} ${this.value}:00`;
                }
            });
        });
    </script>
</x-app-layout>
