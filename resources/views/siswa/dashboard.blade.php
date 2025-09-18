@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        @if(auth()->user()->foto_path)
                            <img src="{{ asset('storage/' . auth()->user()->foto_path) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-12 h-12 rounded-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h1 class="text-lg font-bold">Assalamu'alaikum</h1>
                        <p class="text-teal-100 text-sm">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-2H4v2zM4 15h8v-2H4v2zM4 11h10V9H4v2zM4 7h12V5H4v2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="px-4 py-4">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalMemorizations ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Setoran</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $activePrograms ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Program Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Progress Hafalan</h2>
            @if(isset($studentPrograms) && $studentPrograms->count() > 0)
                <div class="space-y-4">
                    @foreach($studentPrograms as $studentProgram)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium text-gray-900">{{ $studentProgram->program->nama }}</h3>
                            <span class="text-sm font-medium text-teal-600">{{ number_format($studentProgram->progress_cached ?? 0, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                            <div class="bg-teal-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $studentProgram->progress_cached ?? 0 }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Mulai: {{ $studentProgram->tanggal_mulai ? $studentProgram->tanggal_mulai->format('d/m/Y') : '-' }}</span>
                            <span>Target: {{ $studentProgram->tanggal_target ? $studentProgram->tanggal_target->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500">Belum mengikuti program apapun</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Utama</h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('siswa.hafalan.index') }}" 
                   class="flex flex-col items-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors">
                    <div class="w-12 h-12 bg-teal-600 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                            <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172zM11 6a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Hafalan Saya</span>
                </a>
                
                <a href="{{ route('siswa.laporan.index') }}" 
                   class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Laporan</span>
                </a>
                
                <a href="{{ route('siswa.progress.index') }}" 
                   class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Progress</span>
                </a>
                
                <a href="{{ route('siswa.profile.edit') }}" 
                   class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-900">Profil</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="px-4 pb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Setoran Terbaru</h2>
                <a href="{{ route('siswa.hafalan.index') }}" class="text-sm text-teal-600 hover:text-teal-700">Lihat Semua</a>
            </div>
            @if(isset($recentMemorizations) && $recentMemorizations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentMemorizations as $memorization)
                    <div class="border-l-4 border-teal-500 pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">
                                    {{ $memorization->juzTarget->surah->name_id ?? 'Surah tidak ditemukan' }}
                                </h4>
                                <p class="text-sm text-gray-600">
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
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $memorization->nilai }}/100</p>
                                @endif
                            </div>
                        </div>
                        @if($memorization->catatan_guru)
                            <p class="text-sm text-gray-600 mt-2 italic">"{{ $memorization->catatan_guru }}"</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                        <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172zM11 6a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-gray-500">Belum ada setoran hafalan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
