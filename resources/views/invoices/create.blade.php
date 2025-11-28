<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('invoices.store') }}" method="POST" x-data="invoiceForm()">
                        @csrf

                        <!-- Patient Selection -->
                        <div class="mb-6">
                            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                            <select id="patient_id" name="patient_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                                <option value="">Select a patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Appointment (Optional) -->
                        <div class="mb-6">
                            <label for="appointment_id" class="block text-sm font-medium text-gray-700">Link to Appointment (Optional)</label>
                            <select id="appointment_id" name="appointment_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">None</option>
                                @foreach($appointments as $appointment)
                                    <option value="{{ $appointment->id }}">
                                        {{ $appointment->appointment_date->format('d M Y') }} - {{ $appointment->doctor->name }} ({{ $appointment->patient->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Invoice Items -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Items</h3>
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex gap-4 mb-2 items-start">
                                    <div class="flex-grow">
                                        <input type="text" :name="'items[' + index + '][description]'" x-model="item.description" placeholder="Description (e.g. Consultation)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div class="w-32">
                                        <input type="number" :name="'items[' + index + '][amount]'" x-model="item.amount" placeholder="Amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required min="0">
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="mt-1 p-2 text-red-600 hover:text-red-800" x-show="items.length > 1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                            <button type="button" @click="addItem()" class="mt-2 text-sm text-indigo-600 hover:text-indigo-900 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Item
                            </button>
                        </div>

                        <!-- Total -->
                        <div class="flex justify-end mb-6">
                            <div class="text-xl font-bold">
                                Total: Rp <span x-text="formatNumber(total)"></span>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('invoices.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4 self-center">Cancel</a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function invoiceForm() {
            return {
                items: [{ description: '', amount: '' }],
                addItem() {
                    this.items.push({ description: '', amount: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                get total() {
                    return this.items.reduce((sum, item) => sum + (Number(item.amount) || 0), 0);
                },
                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num);
                }
            }
        }
    </script>
</x-app-layout>
