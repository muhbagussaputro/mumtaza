@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold">Beranda Guru</h1>
                    <p class="text-teal-100 text-sm">{{ Auth::user()->name }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="px-4 -mt-4">
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalStudents ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Total Siswa</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPrograms ?? 0 }}</p>
                        <p class="text-xs text-gray-500">Program Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Utama</h2>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('guru.siswa.index') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Data Siswa</p>
                    <p class="text-xs text-gray-500 mt-1">Kelola data siswa</p>
                </div>
            </a>
            
            <a href="{{ route('guru.hafalan.create') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Input Setoran</p>
                    <p class="text-xs text-gray-500 mt-1">Tambah hafalan baru</p>
                </div>
            </a>
            
            <a href="{{ route('guru.hafalan.index') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Riwayat Hafalan</p>
                    <p class="text-xs text-gray-500 mt-1">Lihat semua setoran</p>
                </div>
            </a>
            
            <a href="{{ route('guru.laporan.index') }}" class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition-shadow">
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="font-medium text-gray-900">Laporan</p>
                    <p class="text-xs text-gray-500 mt-1">Lihat progress siswa</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="px-4 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="bg-white rounded-lg shadow-sm">
            @if(isset($recentActivities) && count($recentActivities) > 0)
                @foreach($recentActivities as $activity)
                <div class="p-4 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $activity['student_name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada aktivitas terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
