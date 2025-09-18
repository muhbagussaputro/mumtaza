@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.siswas.index') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Detail Siswa</h1>
                        <p class="text-blue-100 text-sm">{{ $siswa->nama }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.siswas.edit', $siswa) }}" class="bg-blue-400 hover:bg-blue-300 text-white px-4 py-2 rounded-lg font-medium">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Data
                </a>
            </div>
        </div>
    </div>

    <div class="px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                    <!-- Avatar -->
                    <div class="mb-4">
                        @if($siswa->foto_profil)
                            <img src="{{ Storage::url($siswa->foto_profil) }}" alt="{{ $siswa->nama }}" class="w-32 h-32 rounded-full mx-auto object-cover">
                        @else
                            <div class="w-32 h-32 bg-blue-100 rounded-full mx-auto flex items-center justify-center">
                                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Basic Info -->
                    <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $siswa->nama }}</h2>
                    <p class="text-gray-600 mb-2">{{ $siswa->email }}</p>
                    
                    @if($siswa->nis)
                        <p class="text-sm text-gray-500 mb-3">NIS: {{ $siswa->nis }}</p>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="mb-4">
                        @if($siswa->status == 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Aktif
                            </span>
                        @elseif($siswa->status == 'graduated')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                Lulus
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                    
                    <!-- Class Info -->
                    @if($siswa->classRoom)
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $siswa->classRoom->nama }}
                            </span>
                        </div>
                    @endif
                    
                    <!-- Join Date -->
                    <p class="text-sm text-gray-500">
                        Bergabung: {{ $siswa->created_at->format('d F Y') }}
                    </p>
                </div>
            </div>
            
            <!-- Detail Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="text-gray-900">{{ $siswa->nama }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="text-gray-900">{{ $siswa->email }}</p>
                        </div>
                        
                        @if($siswa->nis)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">NIS</label>
                            <p class="text-gray-900">{{ $siswa->nis }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Jenis Kelamin</label>
                            <p class="text-gray-900">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        
                        @if($siswa->tempat_lahir)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tempat Lahir</label>
                            <p class="text-gray-900">{{ $siswa->tempat_lahir }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->tanggal_lahir)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Lahir</label>
                            <p class="text-gray-900">{{ $siswa->tanggal_lahir->format('d F Y') }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->no_hp)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">No. HP</label>
                            <p class="text-gray-900">{{ $siswa->no_hp }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->alamat)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Alamat</label>
                            <p class="text-gray-900">{{ $siswa->alamat }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Academic Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akademik</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kelas</label>
                            <p class="text-gray-900">{{ $siswa->classRoom ? $siswa->classRoom->nama : 'Belum ditentukan' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="text-gray-900">
                                @if($siswa->status == 'active')
                                    Aktif
                                @elseif($siswa->status == 'graduated')
                                    Lulus
                                @else
                                    Tidak Aktif
                                @endif
                            </p>
                        </div>
                        
                        @if($siswa->classRoom && $siswa->classRoom->guru)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Wali Kelas</label>
                            <p class="text-gray-900">{{ $siswa->classRoom->guru->nama }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                            <p class="text-gray-900">{{ $siswa->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Parent Information -->
                @if($siswa->nama_ayah || $siswa->nama_ibu || $siswa->no_hp_ortu || $siswa->pekerjaan_ayah || $siswa->pekerjaan_ibu)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Orang Tua</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($siswa->nama_ayah)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Ayah</label>
                            <p class="text-gray-900">{{ $siswa->nama_ayah }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->nama_ibu)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Ibu</label>
                            <p class="text-gray-900">{{ $siswa->nama_ibu }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->pekerjaan_ayah)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Pekerjaan Ayah</label>
                            <p class="text-gray-900">{{ $siswa->pekerjaan_ayah }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->pekerjaan_ibu)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Pekerjaan Ibu</label>
                            <p class="text-gray-900">{{ $siswa->pekerjaan_ibu }}</p>
                        </div>
                        @endif
                        
                        @if($siswa->no_hp_ortu)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">No. HP Orang Tua</label>
                            <p class="text-gray-900">{{ $siswa->no_hp_ortu }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Hafalan Progress (if exists) -->
                @if($siswa->hafalans && $siswa->hafalans->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Progress Hafalan</h3>
                    
                    <div class="space-y-3">
                        @foreach($siswa->hafalans->take(5) as $hafalan)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $hafalan->surah }} - {{ $hafalan->ayat }}</p>
                                <p class="text-sm text-gray-600">{{ $hafalan->created_at->format('d/m/Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </div>
                        @endforeach
                        
                        @if($siswa->hafalans->count() > 5)
                        <p class="text-sm text-gray-500 text-center">
                            Dan {{ $siswa->hafalans->count() - 5 }} hafalan lainnya...
                        </p>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection