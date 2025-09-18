<div class="grid grid-cols-2 md:grid-cols-4 gap-6">
    <!-- Dashboard -->
    <a href="{{ route('siswa.dashboard') }}"
       class="w-full bg-teal-100 overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-teal-200 flex items-center justify-between hover:bg-teal-200 transition">
        <h2 class="font-bold">Dashboard</h2>
        <i class="fas fa-home text-teal-600"></i>
    </a>

    <!-- Hafalan -->
    <a href="{{ route('siswa.hafalan.index') }}"
       class="w-full bg-teal-100 overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-teal-200 flex items-center justify-between hover:bg-teal-200 transition">
        <h2 class="font-bold">Hafalan</h2>
        <i class="fas fa-book text-teal-600"></i>
    </a>

    <!-- Laporan -->
    <a href="{{ route('siswa.laporan.index') }}"
       class="w-full bg-teal-100 overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-teal-200 flex items-center justify-between hover:bg-teal-200 transition">
        <h2 class="font-bold">Laporan</h2>
        <i class="fas fa-file-alt text-teal-600"></i>
    </a>

    <!-- Progress -->
    <a href="{{ route('siswa.progress.index') }}"
       class="w-full bg-teal-100 overflow-hidden shadow-sm sm:rounded-lg p-6 border-b border-teal-200 flex items-center justify-between hover:bg-teal-200 transition">
        <h2 class="font-bold">Progress</h2>
        <i class="fas fa-chart-line text-teal-600"></i>
    </a>
</div>
