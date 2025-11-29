<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Medical Record') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
        <form action="{{ route('medical_records.update', $medicalRecord) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ (old('patient_id', $medicalRecord->patient_id) == $patient->id) ? 'selected' : '' }}>
                                    {{ $patient->name }} ({{ $patient->nik }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ (old('doctor_id', $medicalRecord->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                                    {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="visit_date" class="block text-sm font-medium text-gray-700">Visit Date</label>
                    <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', $medicalRecord->visit_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('visit_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- ICD Coding -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <h3 class="text-lg font-medium text-blue-900 mb-4">ICD Coding</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="icd10_code" class="block text-sm font-medium text-gray-700">ICD-10 Code</label>
                            <input type="text" name="icd10_code" id="icd10_code" value="{{ old('icd10_code', $medicalRecord->icd10_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. J00">
                        </div>
                        <div>
                            <label for="icd10_name" class="block text-sm font-medium text-gray-700">ICD-10 Diagnosis Name</label>
                            <input type="text" name="icd10_name" id="icd10_name" value="{{ old('icd10_name', $medicalRecord->icd10_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Acute Nasopharyngitis">
                        </div>
                        <div>
                            <label for="icd9_code" class="block text-sm font-medium text-gray-700">ICD-9 Code (Procedure)</label>
                            <input type="text" name="icd9_code" id="icd9_code" value="{{ old('icd9_code', $medicalRecord->icd9_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. 89.07">
                        </div>
                        <div>
                            <label for="icd9_name" class="block text-sm font-medium text-gray-700">ICD-9 Procedure Name</label>
                            <input type="text" name="icd9_name" id="icd9_name" value="{{ old('icd9_name', $medicalRecord->icd9_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Consultation">
                        </div>
                    </div>
                </div>

                <!-- Body Map -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Body Map</h3>
                    <p class="text-sm text-gray-600 mb-2">Draw on the body map to indicate symptoms or injuries.</p>
                    
                    <div class="flex gap-2 mb-2">
                        <button type="button" id="btn-draw" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">Pen</button>
                        <button type="button" id="btn-clear" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Clear</button>
                    </div>

                    <div class="border border-gray-300 bg-white inline-block">
                        <canvas id="bodyMapCanvas" width="500" height="800"></canvas>
                    </div>
                    <input type="hidden" name="body_map_data" id="body_map_data" value="{{ old('body_map_data', json_encode($medicalRecord->body_map_data)) }}">
                </div>

                <!-- Vital Signs -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vital Signs</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php $vs = $medicalRecord->vital_signs ?? []; @endphp
                        <div>
                            <label for="systolic" class="block text-xs font-medium text-gray-500 uppercase">Systolic (mmHg)</label>
                            <input type="number" name="vital_signs[systolic]" id="systolic" value="{{ old('vital_signs.systolic', $vs['systolic'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="diastolic" class="block text-xs font-medium text-gray-500 uppercase">Diastolic (mmHg)</label>
                            <input type="number" name="vital_signs[diastolic]" id="diastolic" value="{{ old('vital_signs.diastolic', $vs['diastolic'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="heart_rate" class="block text-xs font-medium text-gray-500 uppercase">Heart Rate (bpm)</label>
                            <input type="number" name="vital_signs[heart_rate]" id="heart_rate" value="{{ old('vital_signs.heart_rate', $vs['heart_rate'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="respiratory_rate" class="block text-xs font-medium text-gray-500 uppercase">Resp. Rate (bpm)</label>
                            <input type="number" name="vital_signs[respiratory_rate]" id="respiratory_rate" value="{{ old('vital_signs.respiratory_rate', $vs['respiratory_rate'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="oxygen_saturation" class="block text-xs font-medium text-gray-500 uppercase">SpO2 (%)</label>
                            <input type="number" name="vital_signs[oxygen_saturation]" id="oxygen_saturation" value="{{ old('vital_signs.oxygen_saturation', $vs['oxygen_saturation'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="temperature" class="block text-xs font-medium text-gray-500 uppercase">Temp (°C)</label>
                            <input type="number" step="0.1" name="vital_signs[temperature]" id="temperature" value="{{ old('vital_signs.temperature', $vs['temperature'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="weight" class="block text-xs font-medium text-gray-500 uppercase">Weight (kg)</label>
                            <input type="number" step="0.1" name="vital_signs[weight]" id="weight" value="{{ old('vital_signs.weight', $vs['weight'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="height" class="block text-xs font-medium text-gray-500 uppercase">Height (cm)</label>
                            <input type="number" name="vital_signs[height]" id="height" value="{{ old('vital_signs.height', $vs['height'] ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- SOAP -->
                <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                    <h3 class="text-lg font-medium text-indigo-900 mb-4">SOAP Assessment</h3>
                    @php $soap = $medicalRecord->soap_data ?? []; @endphp
                    <div class="space-y-4">
                        <div>
                            <label for="subjective" class="block text-sm font-medium text-gray-700">Subjective (Keluhan Pasien)</label>
                            <textarea name="soap_data[subjective]" id="subjective" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('soap_data.subjective', $soap['subjective'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="objective" class="block text-sm font-medium text-gray-700">Objective (Hasil Pemeriksaan)</label>
                            <textarea name="soap_data[objective]" id="objective" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('soap_data.objective', $soap['objective'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="assessment" class="block text-sm font-medium text-gray-700">Assessment (Diagnosa Kerja)</label>
                            <textarea name="soap_data[assessment]" id="assessment" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('soap_data.assessment', $soap['assessment'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="plan" class="block text-sm font-medium text-gray-700">Plan (Rencana Terapi)</label>
                            <textarea name="soap_data[plan]" id="plan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('soap_data.plan', $soap['plan'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- E-Prescription -->
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <h3 class="text-lg font-medium text-green-900 mb-4">E-Prescription</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-green-200" id="prescription-table">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Medicine</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Quantity</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase">Instructions</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100" id="prescription-body">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addMedicineRow()" class="mt-4 px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Medicine
                    </button>
                </div>

                <!-- Attachments -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Attachments (Lab/X-Ray)</h3>
                    
                    @if($medicalRecord->attachments)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Existing Files:</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600">
                                @foreach($medicalRecord->attachments as $path)
                                    <li>
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="text-indigo-600 hover:underline">{{ basename($path) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="attachments" class="block text-sm font-medium text-gray-700">Upload New Files</label>
                        <input type="file" name="attachments[]" id="attachments" multiple class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        ">
                        <p class="text-xs text-gray-500 mt-1">Allowed: jpg, jpeg, png, pdf. Max: 2MB.</p>
                    </div>
                </div>

                <!-- ICD Coding -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <h3 class="text-lg font-medium text-blue-900 mb-4">ICD Coding (Standard WHO)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="icd10_code" class="block text-sm font-medium text-gray-700">ICD-10 Code (Diagnosis)</label>
                            <div class="flex gap-2">
                                <input type="text" name="icd10_code" id="icd10_code" value="{{ old('icd10_code', $medicalRecord->icd10_code) }}" placeholder="e.g. A00.0" class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <input type="text" name="icd10_name" id="icd10_name" value="{{ old('icd10_name', $medicalRecord->icd10_name) }}" placeholder="Diagnosis Name" class="mt-1 block w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label for="icd9_code" class="block text-sm font-medium text-gray-700">ICD-9-CM Code (Procedure)</label>
                            <div class="flex gap-2">
                                <input type="text" name="icd9_code" id="icd9_code" value="{{ old('icd9_code', $medicalRecord->icd9_code) }}" placeholder="e.g. 89.01" class="mt-1 block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <input type="text" name="icd9_name" id="icd9_name" value="{{ old('icd9_name', $medicalRecord->icd9_name) }}" placeholder="Procedure Name" class="mt-1 block w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis (Summary)</label>
                    <input type="text" name="diagnosis" id="diagnosis" value="{{ old('diagnosis', $medicalRecord->diagnosis) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label for="treatment" class="block text-sm font-medium text-gray-700">Treatment (Summary)</label>
                    <textarea name="treatment" id="treatment" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('treatment', $medicalRecord->treatment) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('medical_records.index') }}" class="mr-4 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Update Record</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Fabric Canvas
            const canvas = new fabric.Canvas('bodyMapCanvas', {
                isDrawingMode: true
            });

            // Set drawing brush
            canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
            canvas.freeDrawingBrush.width = 3;
            canvas.freeDrawingBrush.color = "red";

            // Load Body Map Image
            fabric.Image.fromURL('{{ asset("storage/body_map_outline.png") }}', function(img) {
                const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
                img.set({
                    scaleX: scale,
                    scaleY: scale,
                    originX: 'left',
                    originY: 'top'
                });
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));

                // Load existing data if available
                const existingData = @json($medicalRecord->body_map_data);
                if (existingData) {
                    canvas.loadFromJSON(existingData, canvas.renderAll.bind(canvas));
                }
            });

            // Button Handlers
            document.getElementById('btn-draw').addEventListener('click', function() {
                canvas.isDrawingMode = true;
            });

            document.getElementById('btn-clear').addEventListener('click', function() {
                canvas.clear();
                // Reload background
                fabric.Image.fromURL('{{ asset("storage/body_map_outline.png") }}', function(img) {
                    const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
                    img.set({
                        scaleX: scale,
                        scaleY: scale,
                        originX: 'left',
                        originY: 'top'
                    });
                    canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                });
            });

            // Save to Hidden Input on Submit
            document.querySelector('form').addEventListener('submit', function() {
                const json = JSON.stringify(canvas.toJSON());
                document.getElementById('body_map_data').value = json;
            });

            // ... existing medicine script ...
            let medicineIndex = 0;
            const medicines = @json($medicines);
            const existingItems = @json($medicalRecord->prescriptionItems);

            // Load existing items
            if (existingItems && existingItems.length > 0) {
                existingItems.forEach(item => addMedicineRow(item));
            }
        });
        
        function addMedicineRow(item = null) {
            const tbody = document.getElementById('prescription-body');
            const row = document.createElement('tr');
            
            let options = '<option value="">Select Medicine</option>';
            medicines.forEach(med => {
                const selected = item && item.medicine_id == med.id ? 'selected' : '';
                options += `<option value="${med.id}" ${selected}>${med.name} (Stock: ${med.stock})</option>`;
            });

            const quantity = item ? item.quantity : 1;
            const instructions = item ? (item.instructions || '') : '';

            row.innerHTML = `
                <td class="px-4 py-2">
                    <select name="medicines[${medicineIndex}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        ${options}
                    </select>
                </td>
                <td class="px-4 py-2 w-24">
                    <input type="number" name="medicines[${medicineIndex}][quantity]" min="1" value="${quantity}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                </td>
                <td class="px-4 py-2">
                    <input type="text" name="medicines[${medicineIndex}][instructions]" value="${instructions}" placeholder="e.g. 3x1 after meal" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </td>
                <td class="px-4 py-2 text-center">
                    <button type="button" onclick="this.closest('tr').remove()" class="text-red-600 hover:text-red-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            
            tbody.appendChild(row);
            medicineIndex++;
        }

        // Load existing items
        if (existingItems && existingItems.length > 0) {
            existingItems.forEach(item => addMedicineRow(item));
        }
    </script>
</x-app-layout>
