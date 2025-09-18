@extends('layouts.app')

@section('title', 'Laporan Hafalan')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Laporan Hafalan</h1>
                    <p class="text-gray-600 mt-1">Riwayat setoran hafalan {{ $student->name }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                <form method="GET" action="{{ route('siswa.laporan.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Program Filter -->
                        <div>
                            <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                            <select name="program_id" id="program_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jadwal Filter -->
                        <div>
                            <label for="jadwal" class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                            <select name="jadwal" id="jadwal" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Jadwal</option>
                                <option value="pagi" {{ request('jadwal') == 'pagi' ? 'selected' : '' }}>Pagi</option>
                                <option value="siang" {{ request('jadwal') == 'siang' ? 'selected' : '' }}>Siang</option>
                                <option value="sore" {{ request('jadwal') == 'sore' ? 'selected' : '' }}>Sore</option>
                                <option value="malam" {{ request('jadwal') == 'malam' ? 'selected' : '' }}>Malam</option>
                            </select>
                        </div>

                        <!-- Jenis Setoran Filter -->
                        <div>
                            <label for="jenis_setoran" class="block text-sm font-medium text-gray-700 mb-1">Jenis Setoran</label>
                            <select name="jenis_setoran" id="jenis_setoran" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Jenis</option>
                                <option value="ziyadah" {{ request('jenis_setoran') == 'ziyadah' ? 'selected' : '' }}>Ziyadah</option>
                                <option value="muraja'ah" {{ request('jenis_setoran') == "muraja'ah" ? 'selected' : '' }}>Muraja'ah</option>
                            </select>
                        </div>

                        <!-- Klasifikasi Filter -->
                        <div>
                            <label for="klasifikasi" class="block text-sm font-medium text-gray-700 mb-1">Klasifikasi</label>
                            <select name="klasifikasi" id="klasifikasi" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                                <option value="">Semua Klasifikasi</option>
                                <option value="lancar" {{ request('klasifikasi') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                                <option value="kurang_lancar" {{ request('klasifikasi') == 'kurang_lancar' ? 'selected' : '' }}>Kurang Lancar</option>
                                <option value="tidak_lancar" {{ request('klasifikasi') == 'tidak_lancar' ? 'selected' : '' }}>Tidak Lancar</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <i class="fa-solid fa-filter mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('siswa.laporan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <i class="fa-solid fa-refresh mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if($entries->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-chart-line text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data</h3>
                <p class="text-gray-500">Belum ada riwayat setoran hafalan yang sesuai dengan filter.</p>
            </div>
        @else
            <!-- Entries Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Klasifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entries as $entry)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->program->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->surah->name_latin ?? '-' }}
                                        @if($entry->ayat_mulai && $entry->ayat_selesai)
                                            <br><span class="text-xs text-gray-500">Ayat {{ $entry->ayat_mulai }}-{{ $entry->ayat_selesai }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $entry->jenis_setoran === 'ziyadah' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($entry->jenis_setoran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($entry->klasifikasi === 'lancar') bg-green-100 text-green-800
                                            @elseif($entry->klasifikasi === 'kurang_lancar') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ str_replace('_', ' ', ucfirst($entry->klasifikasi)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->guru->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('siswa.laporan.detail', $entry) }}" 
                                           class="text-teal-600 hover:text-teal-900">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($entries->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $entries->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-submit form when filter changes (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelects = document.querySelectorAll('#program_id, #jadwal, #jenis_setoran, #klasifikasi');
        filterSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                // Optional: Auto-submit on change
                // this.form.submit();
            });
        });
    });
</script>
@endpush