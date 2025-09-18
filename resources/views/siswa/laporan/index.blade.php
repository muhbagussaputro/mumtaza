@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('siswa.dashboard') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Laporan Progress</h1>
                        <p class="text-teal-100 text-sm">Statistik hafalan Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Period -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('siswa.laporan.index') }}">
                <div class="flex gap-2">
                    <select name="period" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="quarter" {{ request('period') == 'quarter' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                        <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                    
                    <select name="program_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Program</option>
                        @if(isset($programs))
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->nama }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="px-4">
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-teal-100 rounded-lg">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_setoran'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Setoran</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['avg_score'] ?? 0, 1) }}</p>
                        <p class="text-sm text-gray-600">Rata-rata Nilai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Distribution -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h3 class="font-semibold text-gray-900 mb-3">Distribusi Status Hafalan</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Lancar</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">{{ $stats['lancar'] ?? 0 }}</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" data-width="{{ $stats['total_setoran'] > 0 ? (($stats['lancar'] ?? 0) / $stats['total_setoran']) * 100 : 0 }}"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Kurang Lancar</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">{{ $stats['kurang_lancar'] ?? 0 }}</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" data-width="{{ $stats['total_setoran'] > 0 ? (($stats['kurang_lancar'] ?? 0) / $stats['total_setoran']) * 100 : 0 }}"></div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700">Tidak Lancar</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900 mr-2">{{ $stats['tidak_lancar'] ?? 0 }}</span>
                        <div class="w-20 bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" data-width="{{ $stats['total_setoran'] > 0 ? (($stats['tidak_lancar'] ?? 0) / $stats['total_setoran']) * 100 : 0 }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress by Program -->
    @if(isset($program_progress) && count($program_progress) > 0)
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h3 class="font-semibold text-gray-900 mb-3">Progress per Program</h3>
            <div class="space-y-4">
                @foreach($program_progress as $program)
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-900">{{ $program['nama'] }}</span>
                        <span class="text-sm text-gray-600">{{ number_format($program['progress'], 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-teal-600 h-2 rounded-full transition-all duration-300" data-width="{{ $program['progress'] }}"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>{{ $program['completed'] }} selesai</span>
                        <span>{{ $program['total'] }} total</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Activity -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h3 class="font-semibold text-gray-900 mb-3">Aktivitas Terbaru</h3>
            @if(isset($recent_activities) && count($recent_activities) > 0)
                <div class="space-y-3">
                    @foreach($recent_activities as $activity)
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['date'] }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($activity['status'] == 'lancar') bg-green-100 text-green-800
                            @elseif($activity['status'] == 'kurang_lancar') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $activity['status'])) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                        <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Button -->
    <div class="px-4 pb-6">
        <a href="{{ route('siswa.laporan.export') }}" class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg font-medium text-center block hover:bg-teal-700 transition-colors">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Laporan PDF
        </a>
    </div>
</div>
@endsection