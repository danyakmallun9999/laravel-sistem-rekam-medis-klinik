<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Queue Display -->
            <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-600 rounded-lg shadow-lg p-6 text-white text-center md:col-span-1">
                    <h3 class="text-lg font-semibold uppercase tracking-wider mb-2">Current Queue</h3>
                    <div class="text-6xl font-bold mb-4">
                        {{ $currentQueue ? $currentQueue->number : '--' }}
                    </div>
                    <div class="text-sm opacity-75">
                        {{ $currentQueue ? $currentQueue->poli : 'No Active Queue' }}
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6 md:col-span-2 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Queue Actions</h3>
                        <p class="text-sm text-gray-500">Manage patient flow efficiently.</p>
                    </div>
                    <a href="{{ route('queues.create') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Generate New Number
                    </a>
                </div>
            </div>

            <!-- Queue List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Today's Queue</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poli</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($queues as $queue)
                                    <tr class="{{ $queue->status == 'called' ? 'bg-indigo-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-xl font-bold text-gray-900">{{ $queue->number }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $queue->poli }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($queue->patient)
                                                <div class="text-sm font-medium text-gray-900">{{ $queue->patient->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $queue->patient->nik }}</div>
                                            @else
                                                <span class="text-sm text-gray-400 italic">Guest</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colors = [
                                                    'waiting' => 'bg-yellow-100 text-yellow-800',
                                                    'called' => 'bg-indigo-100 text-indigo-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'skipped' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$queue->status] }}">
                                                {{ ucfirst($queue->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            @if($queue->status == 'waiting')
                                                <form action="{{ route('queues.updateStatus', $queue) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="called">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold">Call</button>
                                                </form>
                                            @endif

                                            @if($queue->status == 'called')
                                                <form action="{{ route('queues.updateStatus', $queue) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Complete</button>
                                                </form>
                                                <form action="{{ route('queues.updateStatus', $queue) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="skipped">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Skip</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No queues for today.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
