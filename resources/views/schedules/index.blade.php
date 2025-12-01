<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Doctor Schedules') }}
            </h2>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex justify-end mb-4">
                @role('admin')
                <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Schedule
                </a>
                @endrole
            </div>

            <!-- Tabbed Interface -->
            <div x-data="{ activeTab: '{{ strtolower(now()->format('l')) }}' }">
                <!-- Day Tabs -->
                <div class="mb-6 overflow-x-auto pb-2">
                    <nav class="flex space-x-2 min-w-max" aria-label="Tabs">
                        @foreach($days as $day)
                            <button @click="activeTab = '{{ $day }}'" 
                                :class="{ 'bg-indigo-600 text-white shadow-md': activeTab === '{{ $day }}', 'bg-white text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTab !== '{{ $day }}' }"
                                class="px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-200 capitalize whitespace-nowrap">
                                {{ $day }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <!-- Schedule Cards -->
                <div class="space-y-6">
                    @foreach($days as $day)
                        <div x-show="activeTab === '{{ $day }}'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             style="display: none;">
                            
                            @if(isset($schedules[$day]) && count($schedules[$day]) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($schedules[$day] as $schedule)
                                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                                            <div class="p-6">
                                                <div class="flex items-start justify-between mb-4">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                                            {{ substr($schedule->doctor->name, 4, 1) }}
                                                        </div>
                                                        <div class="ml-4">
                                                            <h3 class="text-lg font-bold text-gray-900 line-clamp-1">{{ $schedule->doctor->name }}</h3>
                                                            <p class="text-sm text-indigo-600 font-medium">{{ $schedule->doctor->specialization }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        @if($schedule->is_available)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                                Available
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                                                Unavailable
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                    <div class="flex items-center text-gray-700">
                                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                                                        <span class="mx-2 text-gray-400">-</span>
                                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                                    </div>
                                                </div>

                                                @role('admin')
                                                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="text-gray-500 hover:text-indigo-600 transition-colors p-1" title="Edit Schedule">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors p-1" title="Delete Schedule">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endrole
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                                    <div class="mx-auto h-24 w-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">No Schedules Found</h3>
                                    <p class="text-gray-500 mt-1">There are no doctor schedules available for {{ ucfirst($day) }}.</p>
                                    @role('admin')
                                    <div class="mt-6">
                                        <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Add Schedule for {{ ucfirst($day) }}
                                        </a>
                                    </div>
                                    @endrole
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
