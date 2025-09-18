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
                        <h1 class="text-xl font-bold">Hafalan Saya</h1>
                        <p class="text-teal-100 text-sm">Riwayat setoran hafalan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('siswa.hafalan.index') }}">
                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Status</option>
                        <option value="lancar" {{ request('status') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                        <option value="kurang_lancar" {{ request('status') == 'kurang_lancar' ? 'selected' : '' }}>Kurang Lancar</option>
                        <option value="tidak_lancar" {{ request('status') == 'tidak_lancar' ? 'selected' : '' }}>Tidak Lancar</option>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="px-4">
        <div class="grid grid-cols-3 gap-3 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-green-600">{{ $stats['lancar'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Lancar</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-yellow-600">{{ $stats['kurang_lancar'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Kurang Lancar</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-red-600">{{ $stats['tidak_lancar'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Tidak Lancar</div>
            </div>
        </div>
    </div>

    <!-- Memorizations Table -->
    <div class="px-2 sm:px-4">
        @if(isset($memorizations) && $memorizations->count() > 0)
            <x-responsive-datatable 
                id="hafalanSiswaTable" 
                title="Riwayat Hafalan"
                :headers="['Surah', 'Juz', 'Ayat', 'Status', 'Nilai', 'Tanggal', 'Catatan']">
                
                <x-slot name="mobileCards">
                    @foreach($memorizations as $memorization)
                    <div class="mobile-card p-4 border-b border-gray-200">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">
                                        {{ $memorization->juzTarget->surah->name_id ?? 'Surah tidak ditemukan' }}
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        Juz {{ $memorization->juzTarget->juz_ke ?? '-' }} • 
                                        Ayat {{ $memorization->ayat_mulai }} - {{ $memorization->ayat_selesai }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $memorization->tanggal_setoran->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($memorization->status_hafalan == 'lancar') bg-green-100 text-green-800
                                        @elseif($memorization->status_hafalan == 'kurang_lancar') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $memorization->status_hafalan)) }}
                                    </span>
                                    @if($memorization->nilai)
                                        <div class="text-sm font-medium text-gray-900 mt-1">
                                            {{ $memorization->nilai }}/100
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($memorization->violations && $memorization->violations->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($memorization->violations->take(3) as $violation)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-red-100 text-red-800">
                                            {{ Str::limit($violation->nama, 15) }}
                                        </span>
                                    @endforeach
                                    @if($memorization->violations->count() > 3)
                                        <span class="text-xs text-gray-500">+{{ $memorization->violations->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            @if($memorization->catatan_guru)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs font-medium text-gray-700 mb-1">Catatan Guru:</p>
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit($memorization->catatan_guru, 100) }}
                                        @if(strlen($memorization->catatan_guru) > 100)
                                            <button class="text-blue-600 hover:text-blue-800 ml-1" 
                                                    onclick="alert('{{ addslashes($memorization->catatan_guru) }}')" 
                                                    title="Lihat selengkapnya">
                                                ...selengkapnya
                                            </button>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </x-slot>

                @foreach($memorizations as $memorization)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $memorization->juzTarget->surah->name_id ?? 'Surah tidak ditemukan' }}
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 no-wrap">
                        {{ $memorization->juzTarget->juz_ke ?? '-' }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 no-wrap">
                        {{ $memorization->ayat_mulai }} - {{ $memorization->ayat_selesai }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($memorization->status_hafalan == 'lancar') bg-green-100 text-green-800
                            @elseif($memorization->status_hafalan == 'kurang_lancar') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $memorization->status_hafalan)) }}
                        </span>
                        @if($memorization->violations && $memorization->violations->count() > 0)
                            <div class="mt-1">
                                @foreach($memorization->violations->take(2) as $violation)
                                    <span class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-red-100 text-red-800 mr-1">
                                        {{ Str::limit($violation->nama, 10) }}
                                    </span>
                                @endforeach
                                @if($memorization->violations->count() > 2)
                                    <span class="text-xs text-gray-500">+{{ $memorization->violations->count() - 2 }}</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 no-wrap">
                        {{ $memorization->nilai ? $memorization->nilai . '/100' : '-' }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 no-wrap">
                        {{ $memorization->tanggal_setoran->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-4">
                        @if($memorization->catatan_guru)
                            <div class="text-sm text-gray-700 max-w-xs">
                                {{ Str::limit($memorization->catatan_guru, 50) }}
                                @if(strlen($memorization->catatan_guru) > 50)
                                    <button class="text-blue-600 hover:text-blue-800 ml-1" 
                                            onclick="alert('{{ addslashes($memorization->catatan_guru) }}')" 
                                            title="Lihat selengkapnya">
                                        ...selengkapnya
                                    </button>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </x-responsive-datatable>
        @else
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                    <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172zM11 6a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada setoran hafalan</h3>
                <p class="text-gray-500 text-sm">Setoran hafalan Anda akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize responsive datatable
    $('#hafalanSiswaTable').addClass('responsive-datatable');
    
    window.ResponsiveDataTable.init('hafalanSiswaTable', {
        "pageLength": 15,
        "order": [[5, "desc"]] // Sort by date column
    });
});
</script>
@endpush