<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Current Queue Display -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white text-center max-w-2xl mx-auto relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                    
                    <h3 class="text-xl font-semibold uppercase tracking-widest mb-4 opacity-90">Current Queue</h3>
                    <div class="text-8xl font-black mb-6 tracking-tighter">
                        {{ $currentQueue ? $currentQueue->number : '--' }}
                    </div>
                    <div class="text-2xl font-light opacity-90">
                        {{ $currentQueue ? $currentQueue->poli : 'No Active Queue' }}
                    </div>
                    @if($currentQueue && $currentQueue->patient)
                        <div class="mt-4 text-sm font-medium bg-white/20 inline-block px-4 py-1 rounded-full">
                            {{ $currentQueue->patient->name }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Queue List -->
            <div class="mb-6 flex justify-between items-end">
                <h3 class="text-lg font-medium text-gray-900">Today's Queue</h3>
                <a href="{{ route('queues.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Generate Number
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-0"> <!-- Removed padding for full-width table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Number</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Poli</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($queues as $queue)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $queue->status == 'called' ? 'bg-indigo-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $queue->number }}</span>
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
                                                    'waiting_screening' => 'bg-orange-100 text-orange-800',
                                                    'screening_completed' => 'bg-blue-100 text-blue-800',
                                                    'in_consultation' => 'bg-indigo-100 text-indigo-800',
                                                    'consultation_completed' => 'bg-purple-100 text-purple-800',
                                                    'waiting_pharmacy' => 'bg-teal-100 text-teal-800',
                                                    'waiting_payment' => 'bg-pink-100 text-pink-800',
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

                                                <form id="delete-queue-{{ $queue->id }}" action="{{ route('queues.destroy', $queue) }}" method="POST" class="inline-block ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(event, 'delete-queue-{{ $queue->id }}')" class="text-red-600 hover:text-red-900 font-bold">Delete</button>
                                                </form>
                                            @endif

                                            @if($queue->status == 'called')
                                                <span class="text-indigo-600 font-bold">In Progress</span>
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
