<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Records') }}
        </h2>
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div class="flex-1 max-w-lg">
            <form action="{{ route('medical_records.index') }}" method="GET" class="relative flex items-center gap-2">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Patient, Doctor, or Diagnosis..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-indigo-500">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('medical_records.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Reset</a>
                @endif
            </form>
        </div>
        @unless(auth()->user()->hasRole('front_office'))
        <a href="{{ route('medical_records.create') }}" class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Record
        </a>
        @endunless
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y border divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($records as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->visit_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $record->patient->name }}</div>
                                <div class="text-sm text-gray-500">{{ $record->patient->nik }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->doctor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($record->diagnosis, 30) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('medical_records.show', $record) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                @if(auth()->user()->hasRole('admin') || ($record->isLatestForPatient() && !auth()->user()->hasRole('front_office') && !auth()->user()->hasRole('doctor')))
                                    <a href="{{ route('medical_records.edit', $record) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                @endif
                                @if(auth()->user()->hasRole('admin'))
                                    <form id="delete-form-{{ $record->id }}" action="{{ route('medical_records.destroy', $record) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $record->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $records->links() }}
        </div>
    </div>
</x-app-layout>
