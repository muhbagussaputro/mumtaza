@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('admin.gurus.index') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Detail Guru</h1>
                        <p class="text-teal-100 text-sm">Informasi lengkap guru {{ $guru->nama }}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.gurus.edit', $guru) }}" class="bg-teal-400 hover:bg-teal-300 text-white px-4 py-2 rounded-lg">
                        <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <!-- Avatar -->
                        <div class="w-32 h-32 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            @if($guru->foto_profil)
                                <img src="{{ Storage::url($guru->foto_profil) }}" alt="{{ $guru->nama }}" class="w-32 h-32 rounded-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            @endif
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $guru->nama }}</h2>
                        <p class="text-gray-600 mb-4">{{ $guru->email }}</p>
                        
                        <!-- Status Badge -->
                        <div class="mb-4">
                            @if($guru->status == 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </div>
                        
                        <!-- Quick Info -->
                        <div class="text-sm text-gray-500 space-y-2">
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"/>
                                </svg>
                                Bergabung: {{ $guru->created_at->format('d M Y') }}
                            </div>
                            @if($guru->telepon)
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $guru->telepon }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Detail</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-4">Data Pribadi</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                                        <p class="text-gray-900">{{ $guru->nama }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Email</label>
                                        <p class="text-gray-900">{{ $guru->email }}</p>
                                    </div>
                                    
                                    @if($guru->telepon)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                                            <p class="text-gray-900">{{ $guru->telepon }}</p>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Jenis Kelamin</label>
                                        <p class="text-gray-900">{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    
                                    @if($guru->tempat_lahir || $guru->tanggal_lahir)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</label>
                                            <p class="text-gray-900">
                                                @if($guru->tempat_lahir && $guru->tanggal_lahir)
                                                    {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir->format('d F Y') }}
                                                @elseif($guru->tempat_lahir)
                                                    {{ $guru->tempat_lahir }}
                                                @elseif($guru->tanggal_lahir)
                                                    {{ $guru->tanggal_lahir->format('d F Y') }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if($guru->alamat)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">Alamat</label>
                                            <p class="text-gray-900">{{ $guru->alamat }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Employment Information -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-4">Data Kepegawaian</h4>
                                <div class="space-y-3">
                                    @if($guru->nip)
                                        <div>
                                            <label class="text-sm font-medium text-gray-500">NIP</label>
                                            <p class="text-gray-900">{{ $guru->nip }}</p>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Status</label>
                                        <p class="text-gray-900">
                                            @if($guru->status == 'active')
                                                <span class="text-green-600 font-medium">Aktif</span>
                                            @else
                                                <span class="text-red-600 font-medium">Tidak Aktif</span>
                                            @endif
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Tanggal Bergabung</label>
                                        <p class="text-gray-900">{{ $guru->created_at->format('d F Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                                        <p class="text-gray-900">{{ $guru->updated_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Tambahan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Classes Taught -->
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">0</div>
                            <div class="text-sm text-blue-800">Kelas Diajar</div>
                        </div>
                        
                        <!-- Students -->
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">0</div>
                            <div class="text-sm text-green-800">Total Siswa</div>
                        </div>
                        
                        <!-- Programs -->
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-sm text-purple-800">Program Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection