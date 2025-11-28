<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Profile') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient Info -->
        <div class="lg:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center mb-6">
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-3xl mx-auto mb-4">
                        {{ substr($patient->name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $patient->name }}</h3>
                    <p class="text-gray-500">{{ $patient->nik }}</p>
                </div>

                <div class="space-y-4 border-t border-gray-100 pt-4">
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="font-medium text-gray-900">{{ $patient->dob }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-900 capitalize">{{ $patient->gender }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-gray-900">{{ $patient->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="font-medium text-gray-900">{{ $patient->address }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between">
                    <a href="{{ route('patients.edit', $patient) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit Profile</a>
                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Medical History & Appointments -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Medical Records -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Medical History</h3>
                    <button class="text-sm bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full hover:bg-indigo-100 transition-colors">Add Record</button>
                </div>
                
                @if($patient->medicalRecords->count() > 0)
                    <div class="space-y-4">
                        @foreach($patient->medicalRecords as $record)
                            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                <div class="flex justify-between">
                                    <p class="font-bold text-gray-900">{{ $record->diagnosis }}</p>
                                    <span class="text-xs text-gray-500">{{ $record->visit_date }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($record->treatment, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-2">Dr. {{ $record->doctor->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No medical records found.</p>
                @endif
            </div>

            <!-- Appointments (Placeholder for now) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Appointment History</h3>
                    <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="text-sm bg-green-50 text-green-600 px-3 py-1 rounded-full hover:bg-green-100 transition-colors">Book Appointment</a>
                </div>
                @if($patient->appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($patient->appointments as $appointment)
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <div class="flex justify-between">
                                    <p class="font-bold text-gray-900">{{ $appointment->appointment_date }}</p>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $appointment->notes ?? 'No notes' }}</p>
                                <p class="text-xs text-gray-500 mt-2">Dr. {{ $appointment->doctor->name }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No appointments found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
