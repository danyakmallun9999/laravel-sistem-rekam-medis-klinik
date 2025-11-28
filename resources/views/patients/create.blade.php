<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Patient') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <button type="button" onclick="checkBPJS()" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-indigo-50 text-gray-500 text-sm hover:bg-indigo-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            Check BPJS
                        </button>
                    </div>
                    @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p id="bpjs-status" class="text-xs mt-1 hidden"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address') }}</textarea>
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                        <textarea name="allergies" id="allergies" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="List any known allergies...">{{ old('allergies') }}</textarea>
                        @error('allergies') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="medical_history" class="block text-sm font-medium text-gray-700">Medical History (Anamnesa)</label>
                        <textarea name="medical_history" id="medical_history" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Past diseases, surgeries, etc.">{{ old('medical_history') }}</textarea>
                        @error('medical_history') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('patients.index') }}" class="mr-4 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Save Patient</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function checkBPJS() {
            const nik = document.getElementById('nik').value;
            const statusEl = document.getElementById('bpjs-status');
            
            if (!nik) {
                alert('Please enter NIK first.');
                return;
            }

            statusEl.classList.remove('hidden', 'text-green-600', 'text-red-600');
            statusEl.classList.add('text-gray-500');
            statusEl.textContent = 'Checking BPJS...';

            fetch('{{ route('bpjs.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nik: nik })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    statusEl.textContent = `Status: ${data.data.membership_status} (Class ${data.data.class})`;
                    statusEl.classList.remove('text-gray-500');
                    statusEl.classList.add(data.data.membership_status === 'ACTIVE' ? 'text-green-600' : 'text-red-600');

                    // Auto-fill fields
                    document.getElementById('name').value = data.data.name;
                    document.getElementById('dob').value = data.data.dob;
                    document.getElementById('gender').value = data.data.gender;
                    document.getElementById('address').value = data.data.address;
                    document.getElementById('phone').value = data.data.phone;
                } else {
                    statusEl.textContent = data.message || 'Error checking BPJS.';
                    statusEl.classList.remove('text-gray-500');
                    statusEl.classList.add('text-red-600');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusEl.textContent = 'System error.';
                statusEl.classList.remove('text-gray-500');
                statusEl.classList.add('text-red-600');
            });
        }
    </script>
</x-app-layout>
