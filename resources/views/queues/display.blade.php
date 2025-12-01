<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="10"> <!-- Auto refresh every 10 seconds -->
    <title>Queue Display - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white h-screen overflow-hidden">
    <div class="flex h-full">
        <!-- Left: Current Call -->
        <div class="w-2/3 flex flex-col items-center justify-center border-r border-gray-700 p-12 bg-gray-800">
            <h2 class="text-4xl font-light text-gray-400 uppercase tracking-widest mb-8">Now Serving</h2>
            
            @if($currentQueue)
                <div class="bg-white text-gray-900 rounded-3xl shadow-2xl p-16 text-center w-full max-w-3xl animate-pulse">
                    <div class="text-9xl font-black tracking-tighter mb-4 text-indigo-600">
                        {{ $currentQueue->number }}
                    </div>
                    <div class="text-4xl font-bold text-gray-600">
                        {{ $currentQueue->poli }}
                    </div>
                    <div class="mt-8 text-2xl text-gray-500">
                        {{ $currentQueue->patient->name }}
                    </div>
                </div>
            @else
                <div class="text-6xl font-bold text-gray-600">
                    Waiting...
                </div>
            @endif
        </div>

        <!-- Right: Waiting List -->
        <div class="w-1/3 bg-gray-900 p-8 flex flex-col">
            <h3 class="text-2xl font-semibold text-gray-400 mb-6 border-b border-gray-700 pb-4">Next in Line</h3>
            
            <div class="space-y-4 flex-1 overflow-hidden">
                @forelse($queues->where('status', 'waiting')->take(5) as $queue)
                    <div class="bg-gray-800 rounded-xl p-6 flex justify-between items-center border border-gray-700 shadow-lg">
                        <span class="text-5xl font-bold text-white">{{ $queue->number }}</span>
                        <div class="text-right">
                            <span class="block text-xl text-indigo-400 font-medium">{{ $queue->poli }}</span>
                            <span class="block text-sm text-gray-500">Waiting</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-600 mt-10 text-xl">
                        No patients in queue.
                    </div>
                @endforelse
            </div>

            <div class="mt-auto pt-6 border-t border-gray-800 text-center text-gray-500 text-sm">
                {{ now()->format('l, d F Y H:i') }}
            </div>
        </div>
    </div>
</body>
</html>
