<aside class="fixed inset-y-0 left-0 z-30 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out flex flex-col"
       :class="sidebarOpen ? 'w-64' : 'w-20'">
    
    <!-- Logo & Toggle -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-100">
        <div class="flex items-center" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="bg-gray-900 text-white p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
            <span class="ml-3 text-lg font-bold text-gray-900 tracking-tight">SRME</span>
        </div>
        
        <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 rounded-md hover:bg-gray-100 text-gray-500 focus:outline-none transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': !sidebarOpen}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6">
        <ul class="space-y-1 px-3">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('dashboard') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">Dashboard</span>
                    
                    <!-- Tooltip -->
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Dashboard
                    </div>
                </a>
            </li>

            <!-- Patients -->
            @if((auth()->user()->can('manage patients') && !auth()->user()->hasRole('nurse')) || auth()->user()->hasRole('doctor'))
            <li>
                <a href="{{ route('patients.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('patients.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('patients.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Patients</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Patients
                    </div>
                </a>
            </li>
            @endif

            <!-- Medical Records -->
            @if(auth()->user()->can('view medical records') && !auth()->user()->hasRole('nurse'))
            <li>
                <a href="{{ route('medical_records.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('medical_records.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('medical_records.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Medical Records</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Medical Records
                    </div>
                </a>
            </li>
            @endif

            <!-- Doctors -->
            @can('manage doctors')
            <li>
                <a href="{{ route('doctors.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('doctors.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('doctors.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Doctors</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Doctors
                    </div>
                </a>
            </li>
            @endcan

            <!-- Schedules -->
            @role('admin|doctor')
            <li>
                <a href="{{ route('schedules.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('schedules.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('schedules.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Schedules</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Schedules
                    </div>
                </a>
            </li>
            @endrole

            <!-- Divider -->
            @can('manage pharmacy')
            <li class="my-4 border-t border-gray-100" x-show="sidebarOpen"></li>
            <li class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider" x-show="sidebarOpen">
                Pharmacy
            </li>

            <!-- Inventory -->
            <li>
                <a href="{{ route('pharmacy.inventory') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('pharmacy.inventory*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('pharmacy.inventory*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Inventory</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Inventory
                    </div>
                </a>
            </li>

            <!-- Prescriptions -->
            <li>
                <a href="{{ route('pharmacy.prescriptions') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('pharmacy.prescriptions*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('pharmacy.prescriptions*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Prescriptions</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Prescriptions
                    </div>
                </a>
            </li>
            @endcan

            <!-- Divider -->
            <li class="my-4 border-t border-gray-100" x-show="sidebarOpen"></li>
            <li class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider" x-show="sidebarOpen">
                Front Office
            </li>

            <!-- Appointments -->
            @if(auth()->user()->can('manage patients') && !auth()->user()->hasRole('nurse'))
            <li>
                <a href="{{ route('appointments.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('appointments.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('appointments.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Appointments</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Appointments
                    </div>
                </a>
            </li>
            @endif

            <!-- Invoices -->
            @role('front_office')
            <li>
                <a href="{{ route('invoices.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('invoices.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('invoices.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Billing</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Billing
                    </div>
                </a>
            </li>
            @endrole

            <!-- Billing -->
            @role('admin')
            <li>
                <a href="{{ route('invoices.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('invoices.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('invoices.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Billing</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Billing
                    </div>
                </a>
            </li>
            @endrole

            <!-- Queues -->
            @can('manage queues')
            <li>
                <a href="{{ route('queues.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('queues.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('queues.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Queues</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Queues
                    </div>
                </a>
            </li>
            @endcan

            <!-- Laboratory -->
            @role('admin')
            <li>
                <a href="{{ route('lab.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('lab.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('lab.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">Laboratory</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        Laboratory
                    </div>
                </a>
            </li>
            @endrole

            <!-- Administration -->
            @role('admin')
            <li class="my-4 border-t border-gray-100" x-show="sidebarOpen"></li>
            <li class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider" x-show="sidebarOpen">
                Administration
            </li>

            <li>
                <a href="{{ route('users.index') }}" 
                   class="flex items-center px-3 py-2.5 rounded-md transition-all group relative"
                   :class="request()->routeIs('users.*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'">
                    <svg class="w-5 h-5 flex-shrink-0 transition-colors" :class="request()->routeIs('users.*') ? 'text-gray-900' : 'text-gray-400 group-hover:text-gray-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="ml-3 text-sm whitespace-nowrap" x-show="sidebarOpen">User Management</span>
                    <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-sm opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none">
                        User Management
                    </div>
                </a>
            </li>
            @endrole
        </ul>
    </nav>

    <!-- User Profile (Bottom) -->
    <div class="border-t border-gray-100 p-4">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-sm font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ml-3" x-show="sidebarOpen">
                <p class="text-sm font-medium text-gray-900 truncate w-32">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate w-32">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
