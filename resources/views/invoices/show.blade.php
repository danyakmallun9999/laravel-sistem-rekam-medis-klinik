<x-app-layout>
    <div class="py-12 print:py-0">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 print:max-w-none">
            <!-- Action Bar -->
            <div class="flex justify-between items-center mb-6 print:hidden">
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Invoices
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Invoice
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:shadow-none">
                <div class="p-8 text-gray-900" id="invoice-print">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8 border-b pb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">INVOICE</h1>
                            <p class="text-gray-500 mt-1">#{{ $invoice->invoice_number }}</p>
                            <div class="mt-4">
                                <span class="px-2 py-1 text-xs font-bold rounded-full {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($invoice->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xl font-bold text-gray-800">SRME Clinic</h2>
                            <p class="text-gray-600 text-sm">123 Health Street</p>
                            <p class="text-gray-600 text-sm">Jakarta, Indonesia</p>
                            <p class="text-gray-600 text-sm">contact@srme.com</p>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex justify-between mb-8">
                        <div>
                            <h3 class="text-gray-600 text-sm font-bold uppercase mb-1">Bill To:</h3>
                            <p class="font-bold text-gray-900">{{ $invoice->patient->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $invoice->patient->address }}</p>
                            <p class="text-gray-600 text-sm">{{ $invoice->patient->phone }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-gray-600 text-sm font-bold uppercase mb-1">Date:</h3>
                            <p class="text-gray-900">{{ $invoice->created_at->format('d F Y') }}</p>
                            @if($invoice->appointment)
                                <h3 class="text-gray-600 text-sm font-bold uppercase mt-4 mb-1">Doctor:</h3>
                                <p class="text-gray-900">{{ $invoice->appointment->doctor->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Items -->
                    <table class="w-full mb-8">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="text-left py-3 text-sm font-bold text-gray-600 uppercase">Description</th>
                                <th class="text-right py-3 text-sm font-bold text-gray-600 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-4 text-gray-900">{{ $item->description }}</td>
                                    <td class="py-4 text-right text-gray-900">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="pt-6 text-right font-bold text-gray-900 text-lg">Total</td>
                                <td class="pt-6 text-right font-bold text-gray-900 text-lg">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Footer -->
                    <div class="border-t pt-8 text-center text-gray-500 text-sm">
                        <p>Thank you for choosing SRME Clinic.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
