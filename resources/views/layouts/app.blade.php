<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mumtaza') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 h-full">
    <div class="min-h-screen flex flex-col lg:flex-row">

        <!-- Sidebar Desktop -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <x-application-logo class="h-8 w-auto" />
                    </div>
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                            {{ request()->routeIs('*.dashboard') 
                                ? 'bg-teal-100 text-teal-900' 
                                : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                            <i class="fa-solid fa-house mr-3"></i>
                            Dashboard
                        </a>

                        @if (auth()->user()->role === 'admin')
                            <a href="#"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                {{ request()->routeIs('admin.admin.*') 
                                    ? 'bg-teal-100 text-teal-900' 
                                    : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                                <i class="fa-solid fa-gear mr-3"></i>
                                Admin
                            </a>
                        @endif

                        @if (in_array(auth()->user()->role, ['guru']))
                            <a href="#"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                {{ request()->routeIs('*.students.*') 
                                    ? 'bg-teal-100 text-teal-900' 
                                    : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                                <i class="fa-solid fa-users mr-3"></i>
                                Students
                            </a>

                            <a href="#"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                {{ request()->routeIs('evaluations.*') 
                                    ? 'bg-teal-100 text-teal-900' 
                                    : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                                <i class="fa-solid fa-clipboard-check mr-3"></i>
                                Evaluations
                            </a>
                        @endif

                        @if (in_array(auth()->user()->role, ['siswa']))
                            <a href="#"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                {{ request()->routeIs('siswa.hafalan.*') 
                                    ? 'bg-teal-100 text-teal-900' 
                                    : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                                <i class="fa-solid fa-book mr-3"></i>
                                Hafalan
                            </a>

                            <a href="#"
                               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md
                                {{ request()->routeIs('siswa.laporan.*') 
                                    ? 'bg-teal-100 text-teal-900' 
                                    : 'text-teal-600 hover:bg-teal-50 hover:text-teal-900' }}">
                                <i class="fa-solid fa-chart-line mr-3"></i>
                                Laporan
                            </a>
                        @endif

                    </nav>
                </div>

                <!-- User Info -->
                <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-medium">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">
                                {{ auth()->user()->name }}  
                            </p>
                            <a href="{{ route('profile.edit') }}"
                               class="text-xs font-medium text-teal-600 hover:text-teal-500">
                                View profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main -->
        <div class="flex-1 overflow-auto focus:outline-none">
            @include('layouts.topbar')

            <main class="flex-1 overflow-y-auto focus:outline-none bg-gray-50 pb-16 lg:pb-0">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        @if (session('status'))
                            <div class="p-4 mb-6 rounded-lg bg-green-100 text-green-800">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="p-4 mb-6 rounded-lg bg-red-100 text-red-800">
                                {{ session('error') }}
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('modals')

    @include('layouts.bottomnav')
</body>

</html>
