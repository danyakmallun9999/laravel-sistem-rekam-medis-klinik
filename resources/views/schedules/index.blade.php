<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ viewMode: 'grid' }">
                <div class="flex justify-between items-center mb-6">
                    <!-- View Toggles -->
                    <div class="bg-gray-100 p-1 rounded-lg inline-flex">
                        <button @click="viewMode = 'grid'" :class="{ 'bg-white shadow-sm text-gray-900': viewMode === 'grid', 'text-gray-500 hover:text-gray-900': viewMode !== 'grid' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Grid View
                        </button>
                        <button @click="viewMode = 'list'" :class="{ 'bg-white shadow-sm text-gray-900': viewMode === 'list', 'text-gray-500 hover:text-gray-900': viewMode !== 'list' }" class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            List View
                        </button>
                    </div>

                    @role('admin')
                    <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Schedule
                    </a>
                    @endrole
                </div>

                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Grid View -->
                <div x-show="viewMode === 'grid'" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-r border-gray-200 sticky left-0 bg-gray-50 z-10">Doctor</th>
                                    @foreach($days as $day)
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 min-w-[150px]">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($doctors as $doctor)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 bg-gray-50 sticky left-0 z-10">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                                    {{ substr($doctor->name, 4, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">{{ $doctor->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $doctor->specialization }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($days as $day)
                                            <td class="px-4 py-4 text-center border-r border-gray-100 last:border-r-0 align-top">
                                                @php
                                                    $daySchedules = $doctor->schedules->where('day_of_week', $day);
                                                @endphp
                                                @if($daySchedules->count() > 0)
                                                    <div class="space-y-2">
                                                        @foreach($daySchedules as $schedule)
                                                            <div class="group relative bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-md p-2 text-xs transition-colors duration-200 border border-blue-100">
                                                                <div class="font-semibold">
                                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                                </div>
                                                                
                                                                <!-- Hover Actions -->
                                                                @role('admin')
                                                                <div class="hidden group-hover:flex absolute -top-2 -right-2 bg-white shadow-md rounded-full border border-gray-200 p-1 space-x-1">
                                                                    <a href="{{ route('schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900 p-1" title="Edit">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                                    </a>
                                                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1" title="Delete">
                                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                @endrole
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-300 text-xs">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- List View (Original) -->
                <div x-show="viewMode === 'list'" class="space-y-6" style="display: none;">
                    @forelse($schedules as $day => $daySchedules)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-medium text-gray-900 capitalize">{{ $day }}</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($daySchedules as $schedule)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                                        {{ substr($schedule->doctor->name, 4, 1) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900">{{ $schedule->doctor->name }}</p>
                                                        <p class="text-xs text-gray-500">{{ $schedule->doctor->specialization }}</p>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    @if($schedule->is_available)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </div>
                                            </div>
                                            @role('admin')
                                            <div class="mt-4 flex justify-end space-x-3">
                                                <a href="{{ route('schedules.edit', $schedule) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                            @endrole
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-center text-gray-500">
                                No schedules found.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
