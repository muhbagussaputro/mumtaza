<div class="sticky top-0 z-30 flex items-center justify-between px-4 py-3 bg-teal-500 border-b border-gray-200">
    <!-- Left: Judul Halaman -->
    <h1 class="text-lg font-semibold text-gray-900">
        @yield('title', 'Dashboard')
    </h1>

    <!-- Right: Aksi -->
    <div class="flex items-center space-x-3">
        <!-- Profil dengan Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <!-- Button -->
            <button @click="open = !open" class="flex items-center focus:outline-none">
                <div
                    class="w-9 h-9 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-medium">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </button>

            <!-- Dropdown -->
            <div
                x-show="open"
                @click.outside="open = false"
                x-transition
                class="absolute right-0 mt-2 w-40 bg-teal-500 border border-gray-200 rounded-lg shadow-lg py-1 z-50">

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm text-white hover:bg-teal-600">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-white hover:bg-teal-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
