<nav x-data="{ open: false }" class="bg-teal-500 border-b border-gray-100">
    {{-- Mobile menu button --}}
    <div class="flex items-center md:hidden">
        <button type="button"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-teal-500"
            aria-controls="mobile-menu" aria-expanded="false" data-drawer-target="sidebar" data-drawer-toggle="sidebar"
            @click="open = ! open">
            <span class="sr-only">Open main menu</span>
            <!-- Icon when menu is closed -->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- Icon when menu is open -->
            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Logo --}}
    <div class="flex-shrink-0 flex items-center">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
            {{ config('app.name', 'Laravel') }}
        </a>
    </div>

    {{-- Desktop menu --}}
    <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4 bg-teal-500">
        @if (auth()->user()->role === 'admin')
            <a href="#"
                class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                Admin Dashboard
            </a>
        @endif

        @if (in_array(auth()->user()->role, ['teacher', 'admin']))
            <a href="#"
                class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                Students
            </a>
            <a href="#"
                class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                Evaluations
            </a>
        @endif

        @if (auth()->user()->role === 'student')
            <a href="#"
                class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                My Progress
            </a>
            <a href="#"
                class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                Schedule
            </a>
        @endif

        <a href="#"
            class="px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
            Reports
        </a>
    </div>

    {{-- Right side items --}}
    <div class="hidden md:ml-4 md:flex-shrink-0 md:flex md:items-center">
        <!-- Notifications dropdown -->
        <div class="ml-3 relative">
            <button type="button"
                class="p-1 rounded-full text-white hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>
        </div>

        <!-- Profile dropdown -->
        <div class="ml-3 relative">
            <div>
                <button type="button"
                    class="flex items-center max-w-xs rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                    id="user-menu" aria-expanded="false" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    <div
                        class="h-8 w-8 rounded-full bg-teal-600 flex items-center justify-center text-white font-medium">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu, show/hide based on menu state --}}
    <div class="md:hidden" :class="{ 'block': open, 'hidden': !open }" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role === 'admin')
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                    Admin Dashboard
                </a>
            @endif

            @if (in_array(auth()->user()->role, ['teacher', 'admin']))
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                    Students
                </a>
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                    Evaluations
                </a>
            @endif

            @if (auth()->user()->role === 'student')
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                    My Progress
                </a>
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                    Schedule
                </a>
            @endif

            <a href="#"
                class="block px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                Reports
            </a>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <div
                        class="h-10 w-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-medium">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="#"
                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Your Profile
                </a>
                <a href="#"
                    class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        {{ __('Sign out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
