@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.users.index') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Detail User</h1>
                        <p class="text-teal-100 text-sm">Informasi lengkap pengguna</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" 
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
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-center">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                 alt="Foto Profil" 
                                 class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto mb-4 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        
                        <!-- Status Badges -->
                        <div class="flex justify-center space-x-2 mt-3">
                            <span class="px-2 py-1 text-xs rounded-full {{ $user->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 capitalize">
                                {{ $user->role }}
                            </span>
                            @if($user->email_verified_at)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Email Terverifikasi
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                    Email Belum Terverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Detail</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Role</label>
                                <p class="mt-1 text-sm text-gray-900 capitalize">{{ $user->role }}</p>
                            </div>
                            
                            @if($user->nis)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIS</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->nis }}</p>
                            </div>
                            @endif
                            
                            @if($user->tanggal_lahir)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->tanggal_lahir->format('d F Y') }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Additional Info -->
                        <div class="space-y-4">
                            @if($user->jenis_kelamin)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            @endif
                            
                            @if($user->no_telepon)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->no_telepon }}</p>
                            </div>
                            @endif
                            
                            @if($user->alamat)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->alamat }}</p>
                            </div>
                            @endif
                            
                            @if($user->orang_tua_nama)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->orang_tua_nama }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Bergabung</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d F Y H:i') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Update</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($user->role == 'siswa')
        <!-- Student Programs -->
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Program yang Diikuti</h4>
                
                @if($user->studentPrograms && $user->studentPrograms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($user->studentPrograms as $studentProgram)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h5 class="font-medium text-gray-900">{{ $studentProgram->program->nama_program }}</h5>
                                <p class="text-sm text-gray-600 mt-1">{{ $studentProgram->program->deskripsi }}</p>
                                <div class="mt-2">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $studentProgram->status_aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $studentProgram->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    Bergabung: {{ $studentProgram->created_at->format('d M Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">Belum mengikuti program apapun</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($user->role == 'guru')
        <!-- Teacher Programs -->
        <div class="mt-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Program yang Diampu</h4>
                
                @if($user->teacherPrograms && $user->teacherPrograms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($user->teacherPrograms as $program)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h5 class="font-medium text-gray-900">{{ $program->nama_program }}</h5>
                                <p class="text-sm text-gray-600 mt-1">{{ $program->deskripsi }}</p>
                                <p class="text-xs text-gray-500 mt-2">
                                    Dibuat: {{ $program->created_at->format('d M Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">Belum mengampu program apapun</p>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection