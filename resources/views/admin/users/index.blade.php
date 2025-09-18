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
                        <h1 class="text-xl font-bold">Kelola Users</h1>
                        <p class="text-teal-100 text-sm">Manajemen pengguna sistem</p>
                    </div>
                </div>
                <a href="{{ route('admin.users.create') }}" class="bg-teal-400 hover:bg-teal-300 text-white px-4 py-2 rounded-lg font-medium">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah User
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    
                    <select name="role" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="orang_tua" {{ request('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                    
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
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Total Users</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-green-600">{{ $stats['active'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Aktif</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-yellow-600">{{ $stats['guru'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Guru</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-3 text-center">
                <div class="text-lg font-bold text-purple-600">{{ $stats['siswa'] ?? 0 }}</div>
                <div class="text-xs text-gray-600">Siswa</div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="px-2 sm:px-4">
        <x-responsive-datatable 
            id="usersTable" 
            title="Daftar Users"
            :headers="['Nama', 'Email', 'Role', 'Kelas', 'Status', 'Bergabung', 'Aksi']">
            
            <x-slot name="mobileCards">
                @if(isset($users) && $users->count() > 0)
                    @foreach($users as $user)
                    <div class="mobile-card p-4 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    @if($user->foto_profil)
                                        <img src="{{ $user->foto_profil }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <span class="text-gray-600 font-medium text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($user->role == 'admin') bg-red-100 text-red-800
                                            @elseif($user->role == 'guru') bg-blue-100 text-blue-800
                                            @elseif($user->role == 'siswa') bg-green-100 text-green-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($user->status_aktif) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </div>
                                    @if($user->classRoom)
                                        <p class="text-xs text-gray-500 mt-1">Kelas: {{ $user->classRoom->name }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">Bergabung: {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-900 text-sm">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </x-slot>
            @if(isset($users) && $users->count() > 0)
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                @if($user->foto_profil)
                                    <img src="{{ $user->foto_profil }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span class="text-gray-600 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                @if($user->deleted_at)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Dihapus
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Unverified
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($user->role == 'admin') bg-red-100 text-red-800
                            @elseif($user->role == 'guru') bg-blue-100 text-blue-800
                            @elseif($user->role == 'siswa') bg-green-100 text-green-800
                            @else bg-purple-100 text-purple-800 @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $user->classRoom->name ?? '-' }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($user->status_aktif) bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 no-wrap">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium no-wrap">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if(!$user->deleted_at)
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-900 delete-btn" title="Hapus" data-user-name="{{ $user->name }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.restore', $user->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Restore user">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </x-responsive-datatable>
    </div>
</div>
@endsection

{{-- Session messages akan ditangani oleh global SweetAlert handler --}}
