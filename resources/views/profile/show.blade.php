@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ url()->previous() }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Profil Saya</h1>
                        <p class="text-teal-100 text-sm">Informasi akun pengguna</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-teal-400 hover:bg-teal-300 text-white px-4 py-2 rounded-lg font-medium">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <div class="px-4 py-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center space-x-6">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    @if ($user->foto_path)
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-teal-100"
                            src="{{ asset('storage/' . $user->foto_path) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-24 w-24 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center border-4 border-teal-100">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Profile Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ $user->email }}</p>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($user->role == 'admin') bg-red-100 text-red-800
                            @elseif($user->role == 'guru') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($user->status_aktif) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nomor Telepon</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->telepon ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tempat Lahir</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->tempat_lahir ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Lahir</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Tambahan</h3>
                <div class="space-y-4">
                    @if($user->role === 'siswa')
                        <div>
                            <label class="block text-sm font-medium text-gray-500">NIS</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->nis ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">NISN</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->nisn ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Orang Tua</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->orang_tua_nama ?: '-' }}</p>
                        </div>
                        @if($user->classRoom)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Kelas</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->classRoom->nama_kelas }}</p>
                            </div>
                        @endif
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Akun</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($user->status_aktif) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Bergabung Sejak</label>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address -->
        @if($user->alamat)
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Alamat</h3>
            <p class="text-sm text-gray-900">{{ $user->alamat }}</p>
        </div>
        @endif

        <!-- Account Actions -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Akun</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profil
                </a>
                
                <form method="post" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection