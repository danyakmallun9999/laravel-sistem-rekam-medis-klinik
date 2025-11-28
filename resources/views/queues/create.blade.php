<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Queue Number') }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow mt-10">
        <form action="{{ route('queues.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="poli" class="block text-sm font-medium text-gray-700">Polyclinic</label>
                    <select name="poli" id="poli" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="General">General (Umum)</option>
                        <option value="Dental">Dental (Gigi)</option>
                        <option value="Maternal">Maternal (KIA)</option>
                    </select>
                </div>

                <div>
                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient (Optional)</label>
                    <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Guest / New Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->nik }})</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Leave empty for walk-in guests.</p>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('queues.index') }}" class="mr-4 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors w-full">Generate Number</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
