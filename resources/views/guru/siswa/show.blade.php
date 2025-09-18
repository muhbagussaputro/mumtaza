@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('guru.siswa.index') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">{{ $student->name }}</h1>
                        <p class="text-teal-100 text-sm">Detail Siswa</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('guru.hafalan.create', ['student_id' => $student->id]) }}" 
                       class="px-3 py-2 bg-white text-teal-600 rounded-lg text-sm font-medium hover:bg-gray-50">
                        + Setoran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Info -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                    @if($student->foto_path)
                        <img src="{{ asset('storage/' . $student->foto_path) }}" alt="{{ $student->name }}" class="w-16 h-16 rounded-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $student->name }}</h2>
                    <p class="text-gray-600">NIS: {{ $student->nis ?? '-' }}</p>
                    <p class="text-gray-600">Email: {{ $student->email }}</p>
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $student->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $student->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Program yang Diikuti</h3>
            @if($student->studentPrograms->count() > 0)
                <div class="space-y-4">
                    @foreach($student->studentPrograms as $studentProgram)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $studentProgram->program->nama }}</h4>
                                <p class="text-sm text-gray-600">{{ $studentProgram->program->deskripsi }}</p>
                            </div>
                            <span class="text-sm font-medium text-teal-600">{{ number_format($studentProgram->progress_cached, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-teal-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $studentProgram->progress_cached ?? 0 }}%"></div>
                        </div>
                        <div class="mt-2 flex justify-between text-xs text-gray-500">
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

    <!-- Recent Memorizations -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Setoran Terbaru</h3>
                <a href="{{ route('guru.hafalan.index', ['student_id' => $student->id]) }}" 
                   class="text-sm text-teal-600 hover:text-teal-700">Lihat Semua</a>
            </div>
            @if($recentMemorizations->count() > 0)
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

    <!-- Statistics -->
    <div class="px-4 pb-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-teal-600">{{ $totalMemorizations }}</div>
                    <div class="text-sm text-gray-600">Total Setoran</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $lancarCount }}</div>
                    <div class="text-sm text-gray-600">Lancar</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $kurangLancarCount }}</div>
                    <div class="text-sm text-gray-600">Kurang Lancar</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $tidakLancarCount }}</div>
                    <div class="text-sm text-gray-600">Tidak Lancar</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection