<nav class="fixed bottom-0 inset-x-0 bg-teal-500 border-t border-gray-200 lg:hidden z-40">
    <div class="flex justify-around">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex flex-col items-center justify-center py-2 px-3 text-xs
            {{ request()->routeIs('*.dashboard') 
                ? 'text-white' 
                : 'text-gray-300 hover:text-gray-100' }}">
            <i class="fa-solid fa-house text-xs mb-1"></i>
            Dashboard
        </a>

        <!-- Students (Admin/Teacher Only) -->
        @if (in_array(auth()->user()->role, ['admin']))
            <a href="#"
               class="flex flex-col items-center justify-center py-2 px-3 text-xs
                {{ request()->routeIs('students.*') 
                    ? 'text-white' 
                    : 'text-gray-300 hover:text-gray-100' }}">
                <i class="fa-solid fa-users text-xs mb-1"></i>
                Students
            </a>
        @endif
        @if (in_array(auth()->user()->role, ['guru']))
            <a href="#"
               class="flex flex-col items-center justify-center py-2 px-3 text-xs
                {{ request()->routeIs('students.*') 
                    ? 'text-white' 
                    : 'text-gray-300 hover:text-gray-100' }}">
                <i class="fa-solid fa-users text-xs mb-1"></i>
                Students
            </a>
        @endif
        @if (in_array(auth()->user()->role, ['siswa']))
            <a href="#"
               class="flex flex-col items-center justify-center py-2 px-3 text-xs
                {{ request()->routeIs('siswa.hafalan.*') 
                    ? 'text-white' 
                    : 'text-gray-300 hover:text-gray-100' }}">
                <i class="fa-solid fa-book text-xs mb-1"></i>
                Hafalan
            </a>
            <a href="#"
               class="flex flex-col items-center justify-center py-2 px-3 text-xs
                {{ request()->routeIs('siswa.laporan.*') 
                    ? 'text-white' 
                    : 'text-gray-300 hover:text-gray-100' }}">
                <i class="fa-solid fa-book text-xs mb-1"></i>
                Laporan
            </a>
        @endif

    </div>
</nav>
