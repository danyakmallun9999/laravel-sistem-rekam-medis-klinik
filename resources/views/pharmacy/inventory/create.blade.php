<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Medicine') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow mt-10">
        <form action="{{ route('pharmacy.inventory.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Medicine Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="batch_number" class="block text-sm font-medium text-gray-700">Batch Number</label>
                        <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('batch_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="expired_date" class="block text-sm font-medium text-gray-700">Expired Date</label>
                        <input type="date" name="expired_date" id="expired_date" value="{{ old('expired_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('expired_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('pharmacy.inventory') }}" class="mr-4 px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Save Medicine</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
