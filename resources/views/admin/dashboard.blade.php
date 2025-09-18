@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Admin Dashboard</h1>
                    <p class="text-teal-100">Selamat datang, {{ Auth::user()->name }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-teal-400 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="px-4 py-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Total Users</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_programs'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Program</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_memorizations'] ?? 0 }}</p>
                        <p class="text-sm text-gray-600">Setoran</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['avg_progress'] ?? 0, 1) }}%</p>
                        <p class="text-sm text-gray-600">Avg Progress</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-blue-900">Kelola Users</span>
                </a>
                
                <a href="{{ route('admin.programs.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span class="text-sm font-medium text-green-900">Kelola Program</span>
                </a>
                
                <a href="{{ route('admin.memorizations.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                    <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="text-sm font-medium text-yellow-900">Data Setoran</span>
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span class="text-sm font-medium text-purple-900">Laporan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Users -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Users Terbaru</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-teal-600 text-sm hover:text-teal-700">Lihat Semua</a>
                </div>
                @if(isset($recent_users) && count($recent_users) > 0)
                    <div class="space-y-3">
                        @foreach($recent_users as $user)
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($user->role == 'admin') bg-red-100 text-red-800
                                @elseif($user->role == 'guru') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada user terbaru</p>
                @endif
            </div>
            
            <!-- Recent Memorizations -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">Setoran Terbaru</h3>
                    <a href="{{ route('admin.memorizations.index') }}" class="text-teal-600 text-sm hover:text-teal-700">Lihat Semua</a>
                </div>
                @if(isset($recent_memorizations) && count($recent_memorizations) > 0)
                    <div class="space-y-3">
                        @foreach($recent_memorizations as $memorization)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="font-medium text-gray-900">{{ $memorization->student->name ?? 'Unknown' }}</p>
                                <p class="text-sm text-gray-600">{{ $memorization->juzTarget->surah->name_id ?? 'Surah' }} - Juz {{ $memorization->juzTarget->juz_ke ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $memorization->tanggal_setoran->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($memorization->status_hafalan == 'lancar') bg-green-100 text-green-800
                                @elseif($memorization->status_hafalan == 'kurang_lancar') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $memorization->status_hafalan)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada setoran terbaru</p>
                @endif
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="px-4 py-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="font-semibold text-gray-900 mb-4">System Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <span class="text-sm text-gray-700">Database: Online</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <span class="text-sm text-gray-700">Storage: {{ $system_status['storage_usage'] ?? '0' }}% Used</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <span class="text-sm text-gray-700">Last Backup: {{ $system_status['last_backup'] ?? 'Never' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-6"></div>
</div>
@endsection
