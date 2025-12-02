<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Add Medical Record') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
        <form id="medical-record-form" action="{{ route('medical_records.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8">
                <!-- Basic Info -->
                <!-- Basic Info Card -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Patient & Doctor Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                            <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ (old('patient_id') == $patient->id || (isset($selectedPatientId) && $selectedPatientId == $patient->id)) ? 'selected' : '' }}>
                                        {{ $patient->name }} ({{ $patient->nik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} ({{ $doctor->specialization }})
                                    </option>
                                @endforeach
                            </select>
                            @error('doctor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="visit_date" class="block text-sm font-medium text-gray-700 mb-1">Visit Date & Time</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="datetime-local" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d\TH:i')) }}" class="pl-10 mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>
                        </div>
                        @error('visit_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Allergies -->
                <!-- Allergies -->
                <div class="bg-red-50 p-6 rounded-xl border border-red-200 shadow-sm">
                    <label for="allergies" class="block text-base font-bold text-red-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Patient Allergies (Riwayat Alergi)
                    </label>
                    <textarea name="allergies" id="allergies" rows="2" placeholder="List any known allergies..." class="mt-1 block w-full rounded-lg border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 transition-colors">{{ old('allergies') }}</textarea>
                </div>

                <!-- Responsible Person -->
                <!-- Responsible Person -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Responsible Person (Penanggung Jawab)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="responsible_person_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="responsible_person_name" id="responsible_person_name" value="{{ old('responsible_person_name') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label for="responsible_person_relationship" class="block text-sm font-medium text-gray-700 mb-1">Relationship</label>
                            <input type="text" name="responsible_person_relationship" id="responsible_person_relationship" value="{{ old('responsible_person_relationship') }}" placeholder="e.g. Parent, Spouse" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                    </div>
                </div>



                <!-- Body Map -->
                <!-- Body Map -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Body Map
                        </h3>
                        <div class="flex gap-2">
                            <button type="button" id="btn-draw" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-200 transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Draw
                            </button>
                            <button type="button" id="btn-clear" class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-sm font-semibold hover:bg-red-200 transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Clear
                            </button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Draw on the body map to indicate symptoms or injuries.</p>
                    
                    <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-4 flex justify-center overflow-hidden">
                        <canvas id="bodyMapCanvas" width="800" height="600" class="shadow-sm rounded-lg" style="max-width: 100%; height: auto;"></canvas>
                    </div>
                    <input type="hidden" name="body_map_data" id="body_map_data">
                </div>

                <!-- Vital Signs -->
                <!-- Vital Signs -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        Vital Signs
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="systolic" class="block text-xs font-bold text-gray-500 uppercase mb-1">Systolic</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[systolic]" id="systolic" value="{{ old('vital_signs.systolic') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="120">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">mmHg</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="diastolic" class="block text-xs font-bold text-gray-500 uppercase mb-1">Diastolic</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[diastolic]" id="diastolic" value="{{ old('vital_signs.diastolic') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="80">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">mmHg</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="heart_rate" class="block text-xs font-bold text-gray-500 uppercase mb-1">Heart Rate</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[heart_rate]" id="heart_rate" value="{{ old('vital_signs.heart_rate') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="72">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">bpm</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="respiratory_rate" class="block text-xs font-bold text-gray-500 uppercase mb-1">Resp. Rate</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[respiratory_rate]" id="respiratory_rate" value="{{ old('vital_signs.respiratory_rate') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="18">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">bpm</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="oxygen_saturation" class="block text-xs font-bold text-gray-500 uppercase mb-1">SpO2</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[oxygen_saturation]" id="oxygen_saturation" value="{{ old('vital_signs.oxygen_saturation') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="98">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">%</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="temperature" class="block text-xs font-bold text-gray-500 uppercase mb-1">Temp</label>
                            <div class="relative">
                                <input type="number" step="0.1" name="vital_signs[temperature]" id="temperature" value="{{ old('vital_signs.temperature') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="36.5">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">°C</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="weight" class="block text-xs font-bold text-gray-500 uppercase mb-1">Weight</label>
                            <div class="relative">
                                <input type="number" step="0.1" name="vital_signs[weight]" id="weight" value="{{ old('vital_signs.weight') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="70">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">kg</span>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <label for="height" class="block text-xs font-bold text-gray-500 uppercase mb-1">Height</label>
                            <div class="relative">
                                <input type="number" name="vital_signs[height]" id="height" value="{{ old('vital_signs.height') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="170">
                                <span class="absolute right-3 top-2 text-xs text-gray-400">cm</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SOAP -->
                <!-- SOAP -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        SOAP Assessment
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                            <label for="subjective" class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">S</span>
                                Subjective (Keluhan Pasien)
                            </label>
                            <textarea name="soap_data[subjective]" id="subjective" rows="3" class="block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Patient's complaints...">{{ old('soap_data.subjective') }}</textarea>
                        </div>
                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                            <label for="objective" class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">O</span>
                                Objective (Hasil Pemeriksaan)
                            </label>
                            <textarea name="soap_data[objective]" id="objective" rows="3" class="block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Physical exam findings...">{{ old('soap_data.objective') }}</textarea>
                        </div>
                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                            <label for="assessment" class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">A</span>
                                Assessment (Diagnosa Kerja)
                            </label>
                            <textarea name="soap_data[assessment]" id="assessment" rows="3" class="block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Working diagnosis...">{{ old('soap_data.assessment') }}</textarea>
                        </div>
                        <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                            <label for="plan" class="block text-sm font-bold text-indigo-900 mb-2 flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">P</span>
                                Plan (Rencana Terapi)
                            </label>
                            <textarea name="soap_data[plan]" id="plan" rows="3" class="block w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Treatment plan...">{{ old('soap_data.plan') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- E-Prescription -->
                <!-- E-Prescription -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        E-Prescription
                    </h3>
                    <div class="overflow-hidden border border-gray-200 rounded-xl mb-4">
                        <table class="min-w-full divide-y divide-gray-200" id="prescription-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Instructions</th>
                                    <th class="px-6 py-3 w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="prescription-body">
                                <!-- Dynamic Rows -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="addMedicineRow()" class="px-4 py-2 bg-green-50 text-green-700 text-sm font-semibold rounded-lg hover:bg-green-100 transition-colors flex items-center gap-2 border border-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Medicine
                    </button>
                </div>

                <!-- Attachments -->
                <!-- Attachments -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Attachments (Lab/X-Ray)
                    </h3>
                    <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 text-center hover:bg-gray-100 transition-colors cursor-pointer relative">
                        <input type="file" name="attachments[]" id="attachments" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-2 pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium text-indigo-600 hover:text-indigo-500">Upload a file</span> or drag and drop
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- ICD Coding -->
                <!-- ICD Coding -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        ICD Coding (Standard WHO)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <label for="icd10_code" class="block text-sm font-bold text-blue-900 mb-2">ICD-10 Code (Diagnosis)</label>
                            <div class="flex gap-2">
                                <input type="text" name="icd10_code" id="icd10_code" value="{{ old('icd10_code') }}" placeholder="Code (e.g. A00.0)" class="block w-1/3 rounded-lg border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                <input type="text" name="icd10_name" id="icd10_name" value="{{ old('icd10_name') }}" placeholder="Diagnosis Name" class="block w-2/3 rounded-lg border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <label for="icd9_code" class="block text-sm font-bold text-blue-900 mb-2">ICD-9-CM Code (Procedure)</label>
                            <div class="flex gap-2">
                                <input type="text" name="icd9_code" id="icd9_code" value="{{ old('icd9_code') }}" placeholder="Code (e.g. 89.01)" class="block w-1/3 rounded-lg border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                <input type="text" name="icd9_name" id="icd9_name" value="{{ old('icd9_name') }}" placeholder="Procedure Name" class="block w-2/3 rounded-lg border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <label class="flex items-center">
                            <input type="checkbox" name="informed_consent_signed" value="1" {{ old('informed_consent_signed') ? 'checked' : '' }} class="rounded border-yellow-400 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 w-5 h-5">
                            <span class="ml-3 text-sm font-medium text-yellow-800">Informed Consent Signed (Persetujuan Tindakan Medis telah ditandatangani)</span>
                        </label>
                    </div>
                </div>

                <!-- Legacy Fields -->
                <!-- Medical Summary -->
                <!-- Medical Summary -->
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Medical Summary
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis (Summary)</label>
                            <input type="text" name="diagnosis" id="diagnosis" value="{{ old('diagnosis') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>
                        </div>

                        <div>
                            <label for="treatment" class="block text-sm font-medium text-gray-700 mb-1">Treatment (Summary)</label>
                            <textarea name="treatment" id="treatment" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors" required>{{ old('treatment') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Discharge Status -->
                <!-- Discharge Information -->
                <!-- Discharge Information -->
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <h3 class="text-lg font-bold text-yellow-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Discharge Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="discharge_status" class="block text-sm font-medium text-gray-700 mb-1">Discharge Status (Kondisi Pulang)</label>
                            <select name="discharge_status" id="discharge_status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                <option value="">Select Status</option>
                                <option value="Sembuh" {{ old('discharge_status') == 'Sembuh' ? 'selected' : '' }}>Sembuh</option>
                                <option value="Perbaikan" {{ old('discharge_status') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                <option value="Rujuk" {{ old('discharge_status') == 'Rujuk' ? 'selected' : '' }}>Rujuk</option>
                                <option value="Pulang Paksa" {{ old('discharge_status') == 'Pulang Paksa' ? 'selected' : '' }}>Pulang Paksa</option>
                                <option value="Meninggal" {{ old('discharge_status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                            </select>
                        </div>
                        <div id="referral_hospital_div" class="{{ old('discharge_status') == 'Rujuk' ? '' : 'hidden' }}">
                            <label for="referral_hospital" class="block text-sm font-medium text-gray-700 mb-1">Referral Hospital (RS Rujukan)</label>
                            <input type="text" name="referral_hospital" id="referral_hospital" value="{{ old('referral_hospital') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                        </div>
                    </div>
                </div>

                <!-- Electronic Signature -->
                <!-- Electronic Signature -->
                <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200 shadow-sm">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="is_signed" value="1" required class="mt-1 rounded border-indigo-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-5 h-5">
                        <div class="ml-3">
                            <span class="block text-base font-bold text-indigo-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Electronic Signature (Tanda Tangan Elektronik)
                            </span>
                            <span class="block text-sm text-indigo-700 mt-1">I hereby certify that the medical data entered above is accurate and complete. (Saya menyatakan data ini benar dan melakukan tanda tangan secara elektronik.)</span>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('medical_records.index') }}" class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-sm">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-bold shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Save Record
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/fabric.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure Fabric is loaded
            if (typeof fabric === 'undefined') {
                console.error('Fabric.js not loaded');
                const container = document.getElementById('bodyMapCanvas').parentNode;
                container.innerHTML = '<div class="text-red-500 p-4 text-center font-bold">Error: Fabric.js failed to load.</div>';
                return;
            }

            // Initialize Fabric Canvas
            // Start with default dimensions, will be updated when image loads
            window.canvas = new fabric.Canvas('bodyMapCanvas', {
                isDrawingMode: true,
                width: 800, // Increased default width
                height: 600
            });
            const canvas = window.canvas;

            // Set drawing brush
            canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
            canvas.freeDrawingBrush.width = 3;
            canvas.freeDrawingBrush.color = "red";

            // Load Body Map Image
            const imageUrl = '/storage/body-map.jpg?t=' + new Date().getTime();
            
            console.log('Attempting to load body map image from:', imageUrl);

            function setCanvasBackground(url) {
                // Load Body Map Image using native Image object for better control
                const img = new Image();
                img.crossOrigin = 'anonymous';
                
                img.onload = function() {
                    console.log('Native image loaded successfully', img.width, img.height);
                    
                    const fabricImg = new fabric.Image(img);
                    
                    // Calculate aspect ratio
                    const aspectRatio = img.height / img.width;
                    
                    // Set canvas width to a reasonable max
                    const newWidth = 800;
                    const newHeight = newWidth * aspectRatio;

                    // Resize canvas to match image aspect ratio
                    canvas.setDimensions({ width: newWidth, height: newHeight });

                    // Scale image to fit the new canvas dimensions exactly
                    const scale = newWidth / img.width;
                    
                    canvas.setBackgroundImage(fabricImg, canvas.renderAll.bind(canvas), {
                        scaleX: scale,
                        scaleY: scale,
                        left: newWidth / 2,
                        top: newHeight / 2,
                        originX: 'center',
                        originY: 'center'
                    });
                    
                    console.log('Canvas resized to', newWidth, 'x', newHeight, 'and background image set');
                };

                img.onerror = function(err) {
                    console.error('Failed to load body map image natively', err);
                    // Show error in UI
                    const container = document.getElementById('bodyMapCanvas').parentNode;
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'text-red-500 p-4 text-center font-bold';
                    errorMsg.textContent = 'Error: Failed to load body map image. Please check console for details.';
                    container.appendChild(errorMsg);
                };

                img.src = url;
            }

            setCanvasBackground(imageUrl);

            // Button Handlers
            document.getElementById('btn-draw').addEventListener('click', function() {
                canvas.isDrawingMode = true;
            });

            document.getElementById('btn-clear').addEventListener('click', function() {
                canvas.clear();
                // Re-set the background image after clearing
                setCanvasBackground(imageUrl);
            });

            // Save to Hidden Input on Submit
            document.getElementById('medical-record-form').addEventListener('submit', function() {
                const json = JSON.stringify(canvas.toJSON());
                console.log('Submitting form. Body Map Data:', json);
                document.getElementById('body_map_data').value = json;
            });

            // ... existing medicine script ...
        });
        
        let medicineIndex = 0;
        const medicines = @json($medicines);

        function addMedicineRow() {
            const tbody = document.getElementById('prescription-body');
            const row = document.createElement('tr');
            
            let options = '<option value="">Select Medicine</option>';
            medicines.forEach(med => {
                options += `<option value="${med.id}">${med.name} (Stock: ${med.stock})</option>`;
            });

            row.innerHTML = `
                <td class="px-4 py-2">
                    <select name="medicines[${medicineIndex}][id]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        ${options}
                    </select>
                </td>
                <td class="px-4 py-2 w-24">
                    <input type="number" name="medicines[${medicineIndex}][quantity]" min="1" value="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                </td>
                <td class="px-4 py-2">
                    <input type="text" name="medicines[${medicineIndex}][instructions]" placeholder="e.g. 3x1 after meal" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
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
    </script>
</x-app-layout>
