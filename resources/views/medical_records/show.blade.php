<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Record Details') }}
        </h2>
    </x-slot>

    <!-- Unified Header -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden mb-6 border border-gray-100">
            <div class="p-6 sm:p-8">
                <div class="mb-6">
                    <a href="{{ route('medical_records.index') }}" class="group inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Medical Records
                    </a>
                </div>
                
                <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                COMPLETED
                            </span>Back to Medical Records
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                #MR-{{ $medicalRecord->id }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 leading-tight">
                            {{ $medicalRecord->diagnosis }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-gray-500 text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $medicalRecord->visit_date->format('d F Y') }}</span>
                            </div>
                            <span class="text-gray-300">|</span>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $medicalRecord->visit_date->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compliance & Safety Alerts -->
            @if($medicalRecord->allergies)
            <!-- Compliance & Safety Alerts -->
            @if($medicalRecord->allergies)
            <div class="px-6 sm:px-8 mb-6">
                <div class="bg-red-50 rounded-lg p-4 border border-red-100 flex items-start gap-4">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-900 mb-0.5">Patient Allergies</h3>
                        <p class="text-sm text-red-700 leading-relaxed">
                            {{ $medicalRecord->allergies }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            @endif

            <!-- Patient & Doctor Info Bar -->
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                        {{ substr($medicalRecord->patient->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Patient</p>
                        <p class="font-bold text-gray-900">{{ $medicalRecord->patient->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 md:justify-end">
                    <div class="text-right hidden md:block">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Doctor</p>
                        <p class="font-bold text-gray-900">{{ $medicalRecord->doctor->name }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
                        {{ substr($medicalRecord->doctor->name, 0, 1) }}
                    </div>
                    <div class="md:hidden">
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Doctor</p>
                        <p class="font-bold text-gray-900">{{ $medicalRecord->doctor->name }}</p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Main Content -->
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden p-6 sm:p-8 space-y-8">
            
            <!-- Responsible Person & Discharge Info Cards -->
            @if($medicalRecord->responsible_person_name || $medicalRecord->discharge_status)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($medicalRecord->responsible_person_name)
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Responsible Person
                    </h3>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Name</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $medicalRecord->responsible_person_name }}</p>
                        <p class="text-indigo-600 font-medium">{{ $medicalRecord->responsible_person_relationship }}</p>
                    </div>
                </div>
                @endif

                @if($medicalRecord->discharge_status)
                <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-200 shadow-sm">
                    <h3 class="text-lg font-bold text-yellow-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Discharge Information
                    </h3>
                    <div>
                        <p class="text-sm text-yellow-800 uppercase tracking-wider font-semibold mb-1">Status</p>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-sm font-bold 
                                {{ $medicalRecord->discharge_status == 'Sembuh' ? 'bg-green-100 text-green-800' : 
                                   ($medicalRecord->discharge_status == 'Rujuk' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($medicalRecord->discharge_status == 'Meninggal' ? 'bg-gray-800 text-white' : 'bg-white text-gray-800 border border-gray-200')) }}">
                                {{ $medicalRecord->discharge_status }}
                            </span>
                            @if($medicalRecord->referral_hospital)
                                <span class="text-yellow-900 font-medium">to {{ $medicalRecord->referral_hospital }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- AI Clinical Analysis -->
            @if($medicalRecord->clinical_analysis)
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 shadow-sm">
                <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    AI Clinical Insights
                    <span class="ml-2 px-2 py-0.5 rounded text-xs font-bold bg-blue-200 text-blue-800">BETA</span>
                </h3>
                <div class="space-y-3">
                    @foreach($medicalRecord->clinical_analysis as $analysis)
                        <div class="flex items-start gap-3 p-3 rounded-lg {{ $analysis['type'] === 'danger' ? 'bg-red-50 border border-red-100' : 'bg-yellow-50 border border-yellow-100' }}">
                            @if($analysis['type'] === 'danger')
                                <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            @else
                                <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                            <div>
                                <h4 class="font-bold {{ $analysis['type'] === 'danger' ? 'text-red-800' : 'text-yellow-800' }}">{{ $analysis['title'] }}</h4>
                                <p class="{{ $analysis['type'] === 'danger' ? 'text-red-700' : 'text-yellow-700' }} text-sm">{{ $analysis['message'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- ICD Coding -->
            @if($medicalRecord->icd10_code || $medicalRecord->icd9_code)
            <div class="bg-blue-50 rounded-xl p-6 border border-blue-100 shadow-sm">
                <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    ICD Coding (Standard WHO)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($medicalRecord->icd10_code)
                    <div class="bg-white p-4 rounded-lg border border-blue-100">
                        <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">ICD-10 Diagnosis</h4>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 font-mono font-bold rounded">{{ $medicalRecord->icd10_code }}</span>
                            <span class="text-gray-900 font-medium">{{ $medicalRecord->icd10_name }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($medicalRecord->icd9_code)
                    <div class="bg-white p-4 rounded-lg border border-blue-100">
                        <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">ICD-9 Procedure</h4>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 font-mono font-bold rounded">{{ $medicalRecord->icd9_code }}</span>
                            <span class="text-gray-900 font-medium">{{ $medicalRecord->icd9_name }}</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($medicalRecord->informed_consent_signed)
                    <div class="col-span-1 md:col-span-2 mt-2">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informed Consent Signed
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Vital Signs -->
            @if($medicalRecord->vital_signs)
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Vital Signs
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($medicalRecord->vital_signs as $key => $value)
                        @if($value)
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $value }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- SOAP Data -->
            @if($medicalRecord->soap_data)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($medicalRecord->soap_data as $key => $value)
                    @if($value)
                    <div class="bg-indigo-50/50 rounded-xl p-5 border border-indigo-100">
                        <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-2">{{ ucfirst($key) }}</h4>
                        <p class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $value }}</p>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif

            <!-- Treatment -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Treatment Summary
                </h3>
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 text-gray-700 leading-relaxed">
                    {{ $medicalRecord->treatment }}
                </div>
            </div>

            <!-- Prescriptions -->
            @if($medicalRecord->prescriptionItems->count() > 0)
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Prescription
                </h3>
                <div class="overflow-hidden border border-gray-200 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($medicalRecord->prescriptionItems as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->medicine->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->instructions ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

                <!-- Body Map -->
                <!-- Body Map -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Body Map
                    </h3>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 inline-block">
                        <canvas id="bodyMapCanvas" width="800" height="600" style="max-width: 100%; height: auto;"></canvas>
                    </div>
                </div>

            <!-- Attachments -->
            @if($medicalRecord->attachments)
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    Attachments
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($medicalRecord->attachments as $path)
                        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="group block p-4 border border-gray-200 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all text-center bg-white">
                            <div class="w-10 h-10 mx-auto bg-indigo-50 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-100 transition-colors">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900 truncate block">{{ basename($path) }}</span>
                            <span class="text-xs text-gray-500 mt-1 block">Click to view</span>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Lab Results -->
            @if($medicalRecord->labResults->count() > 0)
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Laboratory Results
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($medicalRecord->labResults as $result)
                        <div class="bg-purple-50 rounded-xl p-5 border border-purple-100 flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-purple-900">{{ $result->test_name }}</h4>
                                <p class="text-xs text-purple-600 mt-1">{{ $result->created_at->format('d M Y H:i') }}</p>
                                @if($result->notes)
                                    <p class="text-sm text-gray-600 mt-2">{{ $result->notes }}</p>
                                @endif
                            </div>
                            @if($result->file_path)
                                <a href="{{ asset('storage/' . $result->file_path) }}" target="_blank" class="px-3 py-1 bg-white text-purple-600 text-sm font-medium rounded-lg border border-purple-200 hover:bg-purple-50 transition-colors">
                                    View Result
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Electronic Signature Footer -->
            <!-- Electronic Signature Footer -->
            @if($medicalRecord->is_signed)
            <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-200 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-indigo-900">Digitally Verified & Signed</h3>
                        <p class="text-indigo-700 text-sm">This record has been electronically signed and verified.</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-indigo-500 uppercase tracking-wider font-semibold">Signed by</p>
                    <p class="font-bold text-indigo-900 text-lg">{{ $medicalRecord->doctor->name }}</p>
                    <p class="text-sm text-indigo-600 font-mono">{{ $medicalRecord->signed_at ? $medicalRecord->signed_at->format('d M Y • H:i:s') : '' }}</p>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                @if(auth()->user()->hasRole('admin') || ($medicalRecord->isLatestForPatient() && !auth()->user()->hasRole('front_office') && !auth()->user()->hasRole('doctor')))
                <a href="{{ route('medical_records.edit', $medicalRecord) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit Record
                </a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                <form action="{{ route('medical_records.destroy', $medicalRecord) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this medical record? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Delete Record
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

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

        const canvas = new fabric.Canvas('bodyMapCanvas', {
            isDrawingMode: false,
            selection: false,
            width: 800,
            height: 600
        });

        // Load Body Map Image using relative path
        const imageUrl = '/storage/body-map.jpg?t=' + new Date().getTime();
        
        console.log('Attempting to load body map image from:', imageUrl);

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

            // Load data
            const existingData = @json($medicalRecord->body_map_data);
            if (existingData) {
                canvas.loadFromJSON(existingData, function() {
                    canvas.getObjects().forEach(function(o) {
                        o.selectable = false;
                        o.evented = false;
                    });
                    canvas.renderAll();
                });
            }
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

        img.src = imageUrl;
    });
</script>
