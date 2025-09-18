@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('guru.hafalan.index') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Detail Hafalan</h1>
                        <p class="text-teal-100 text-sm">Informasi lengkap hafalan siswa</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('guru.hafalan.edit', $hafalan->id) }}" 
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Student Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-center">
                        @if($hafalan->student->foto_profil)
                            <img src="{{ asset('storage/' . $hafalan->student->foto_profil) }}" 
                                 alt="Foto Profil" 
                                 class="w-20 h-20 rounded-full mx-auto mb-4 object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <h3 class="text-lg font-semibold text-gray-900">{{ $hafalan->student->name }}</h3>
                        <p class="text-gray-600">{{ $hafalan->student->email }}</p>
                        @if($hafalan->student->nis)
                            <p class="text-sm text-gray-500">NIS: {{ $hafalan->student->nis }}</p>
                        @endif
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Program:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $hafalan->program->nama_program }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Guru:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $hafalan->guru->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hafalan Details Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Detail Hafalan</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Juz</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">Juz {{ $hafalan->juz }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Surah</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->surah }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ayat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->ayat_mulai }} - {{ $hafalan->ayat_selesai }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Hafalan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->tanggal_hafalan->format('d F Y') }}</p>
                            </div>
                        </div>
                        
                        <!-- Assessment Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($hafalan->status == 'lulus') bg-green-100 text-green-800
                                    @elseif($hafalan->status == 'mengulang') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($hafalan->status) }}
                                </span>
                            </div>
                            
                            @if($hafalan->nilai)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nilai</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $hafalan->nilai }}</p>
                            </div>
                            @endif
                            
                            @if($hafalan->catatan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->catatan }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dicatat pada</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->created_at->format('d F Y H:i') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Update</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $hafalan->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Card -->
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Progress Hafalan Siswa</h4>
                
                @php
                    $totalHafalan = $studentProgress->count();
                    $hafalanLulus = $studentProgress->where('status', 'lulus')->count();
                    $progressPercentage = $totalHafalan > 0 ? ($hafalanLulus / $totalHafalan) * 100 : 0;
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $totalHafalan }}</div>
                        <div class="text-sm text-gray-600">Total Hafalan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $hafalanLulus }}</div>
                        <div class="text-sm text-gray-600">Lulus</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $studentProgress->where('status', 'mengulang')->count() }}</div>
                        <div class="text-sm text-gray-600">Mengulang</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-teal-600">{{ number_format($progressPercentage, 1) }}%</div>
                        <div class="text-sm text-gray-600">Progress</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                </div>
            </div>
        </div>

        <!-- Recent Hafalan -->
        @if($recentHafalan->count() > 0)
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Hafalan Terbaru Siswa</h4>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Juz
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Surah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ayat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentHafalan as $recent)
                                <tr @if($recent->id == $hafalan->id) class="bg-teal-50" @endif>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $recent->tanggal_hafalan->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Juz {{ $recent->juz }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $recent->surah }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $recent->ayat_mulai }}-{{ $recent->ayat_selesai }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($recent->status == 'lulus') bg-green-100 text-green-800
                                            @elseif($recent->status == 'mengulang') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($recent->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $recent->nilai ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection