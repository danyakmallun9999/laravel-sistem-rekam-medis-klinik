<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Lab Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-medium text-gray-900">Patient Information</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Name:</span>
                                <span class="font-medium ml-2">{{ $record->patient->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">NIK:</span>
                                <span class="font-medium ml-2">{{ $record->patient->nik }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Doctor:</span>
                                <span class="font-medium ml-2">{{ $record->doctor->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Visit Date:</span>
                                <span class="font-medium ml-2">{{ $record->visit_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('lab.store', $record) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="test_name" class="block text-sm font-medium text-gray-700">Test Name</label>
                                <input type="text" name="test_name" id="test_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Complete Blood Count" required>
                                @error('test_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700">Result File (PDF/Image)</label>
                                <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100" required>
                                <p class="text-xs text-gray-500 mt-1">Max size: 5MB.</p>
                                @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end gap-4">
                                <a href="{{ route('lab.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">Cancel</a>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Upload Result</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
