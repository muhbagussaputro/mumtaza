@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Kelola Guru</h1>
                        <p class="text-teal-100 text-sm">Manajemen data guru</p>
                    </div>
                </div>
                <a href="{{ route('admin.gurus.create') }}" class="bg-teal-400 hover:bg-teal-300 text-white px-4 py-2 rounded-lg font-medium">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Guru
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('admin.gurus.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email guru..." class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('admin.gurus.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="px-4">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-blue-600">{{ $gurus->total() }}</div>
                <div class="text-xs text-gray-600">Total Guru</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-green-600">{{ $gurus->where('status', 'active')->count() }}</div>
                <div class="text-xs text-gray-600">Aktif</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-red-600">{{ $gurus->where('status', 'inactive')->count() }}</div>
                <div class="text-xs text-gray-600">Tidak Aktif</div>
            </div>
        </div>
    </div>

    <!-- Teachers List -->
    <div class="px-4">
        @if($gurus->count() > 0)
            <div class="space-y-4">
                @foreach($gurus as $guru)
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-start space-x-3">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                                @if($guru->foto_profil)
                                    <img src="{{ Storage::url($guru->foto_profil) }}" alt="{{ $guru->nama }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <h3 class="font-semibold text-gray-900">{{ $guru->nama }}</h3>
                                    @if($guru->trashed())
                                        <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Dihapus
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $guru->email }}</p>
                                @if($guru->telepon)
                                    <p class="text-sm text-gray-600">{{ $guru->telepon }}</p>
                                @endif
                                
                                <!-- Personal Info -->
                                <div class="mt-2 text-sm text-gray-500">
                                    @if($guru->tempat_lahir && $guru->tanggal_lahir)
                                        <p>{{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir->format('d/m/Y') }}</p>
                                    @endif
                                    @if($guru->alamat)
                                        <p>{{ Str::limit($guru->alamat, 50) }}</p>
                                    @endif
                                </div>
                                
                                <!-- Status -->
                                <div class="flex items-center mt-2 space-x-4">
                                    <div class="flex items-center text-sm">
                                        @if($guru->status == 'active')
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            <span class="text-green-700">Aktif</span>
                                        @else
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                            <span class="text-red-700">Tidak Aktif</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Bergabung: {{ $guru->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <!-- View Button -->
                            <a href="{{ route('admin.gurus.show', $guru) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('admin.gurus.edit', $guru) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            
                            <!-- Toggle Status Button -->
                            <button data-toggle-status="{{ $guru->id }}" data-current-status="{{ $guru->status }}" class="toggle-status-btn p-2 text-purple-600 hover:bg-purple-50 rounded-lg">
                                @if($guru->status == 'active')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </button>
                            
                            <!-- Delete Button -->
                            <button data-delete-guru="{{ $guru->id }}" data-guru-nama="{{ $guru->nama }}" class="delete-guru-btn p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $gurus->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data guru</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan guru pertama</p>
                <a href="{{ route('admin.gurus.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
                    Tambah Guru
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

{{-- SweetAlert sudah dimuat secara global di layout --}}