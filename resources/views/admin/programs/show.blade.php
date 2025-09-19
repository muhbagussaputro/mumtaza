@extends('layouts.app')

@section('title', 'Detail Program')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Navigation Bar -->
    <!-- <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-semibold text-gray-800">
                        <i class="fas fa-graduation-cap mr-2 text-green-600"></i>
                        Sistem Hafalan Quran
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.programs.index') }}" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-book mr-1"></i> Program
                    </a>
                    <div class="relative">
                        <button class="flex items-center text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium" onclick="toggleUserMenu()">
                            <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }}
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav> -->

    <div class="max-w-7xl">
        <!-- Header with Gradient -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg mb-8">
            <div class="px-8 py-6">
                <!-- Breadcrumb -->
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-white hover:text-green-100">
                                <i class="fas fa-home mr-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-green-200 mx-2"></i>
                                <a href="{{ route('admin.programs.index') }}" class="ml-1 text-sm font-medium text-white hover:text-green-100 md:ml-2">Program</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-right text-green-200 mx-2"></i>
                                <span class="ml-1 text-sm font-medium text-green-100 md:ml-2">{{ $program->nama }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Page Heading -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white">Detail Program</h1>
                        <p class="mt-2 text-lg text-green-100">Informasi lengkap program hafalan</p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex space-x-3">
                        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center px-4 py-2 border border-green-300 rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <a href="{{ route('admin.programs.edit', $program->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-green-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i> Edit Program
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <!-- Content -->
    <div class="space-y-8">
        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <!-- Program Info Card -->
            <div class="xl:col-span-3">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                        <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-green-500"></i> Informasi Program
                        </h6>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <h4 class="text-xl font-bold text-green-600">{{ $program->nama }}</h4>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $program->jenis == 'reguler' ? 'bg-green-100 text-green-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ ucfirst($program->jenis) }}
                            </span>
                        </div>
                        
                        @if($program->deskripsi)
                        <div class="mb-6">
                            <h6 class="font-semibold text-gray-900 mb-2">Deskripsi:</h6>
                            <p class="text-gray-600 leading-relaxed">{{ $program->deskripsi }}</p>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h6 class="font-semibold text-gray-900 mb-2">Guru Pembimbing:</h6>
                                <p class="text-gray-600">{{ $program->guru ? $program->guru->name : 'Belum ditentukan' }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h6 class="font-semibold text-gray-900 mb-2">Target Juz:</h6>
                                <p class="text-gray-600">{{ $program->juzTargets->count() }} juz</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h6 class="font-semibold text-gray-900 mb-2">Dibuat:</h6>
                                <p class="text-gray-600">{{ $program->created_at->format('d F Y H:i') }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h6 class="font-semibold text-gray-900 mb-2">Terakhir Update:</h6>
                                <p class="text-gray-600">{{ $program->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                        <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-green-500"></i> Statistik
                        </h6>
                    </div>
                    <div class="p-6">
                        <div class="text-center space-y-6">
                            <div class="pb-6 border-b border-gray-200">
                                <h4 class="text-3xl font-bold text-green-600">{{ $program->students->count() }}</h4>
                                <p class="text-sm text-gray-600 font-medium">Total Siswa</p>
                            </div>
                            <div class="pb-6 border-b border-gray-200">
                                <h4 class="text-3xl font-bold text-emerald-600">{{ $program->students->where('pivot.status_aktif', true)->count() }}</h4>
                                <p class="text-sm text-gray-600 font-medium">Siswa Aktif</p>
                            </div>
                            <div>
                                <h4 class="text-3xl font-bold text-blue-600">{{ $program->juzTargets->count() }}</h4>
                                <p class="text-sm text-gray-600 font-medium">Target Juz</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <!-- <div class="bg-white rounded-xl shadow-lg border border-gray-200 mt-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                        <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-bolt mr-2 text-green-500"></i> Aksi Cepat
                        </h6>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.programs.edit', $program) }}" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-edit mr-2"></i> Edit Program
                        </a>
                        <button onclick="openManageStudentsModal()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-users mr-2"></i> Kelola Siswa
                        </button>
                        <button onclick="openMemorizationModal()" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-book-open mr-2"></i> Lihat Hafalan
                        </button>
                    </div>
                </div> -->
            </div>
        </div>


        <!-- Students List -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users mr-2 text-green-500"></i> Daftar Siswa Program
                </h6>
            </div>
            <div class="p-6">
                @if($program->students && $program->students->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" id="studentsTable">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bergabung</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($program->students as $index => $student)
                                    <tr class="hover:bg-green-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->nis ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->classRoom ? $student->classRoom->nama : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->pivot->created_at ? $student->pivot->created_at->format('d M Y') : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="relative inline-block text-left">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 bg-white hover:bg-green-50 hover:border-green-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200" onclick="toggleDropdown({{ $index }})">
                                                    <i class="fas fa-cog text-green-600"></i>
                                                </button>
                                                <div id="dropdown-{{ $index }}" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1">
                                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                                            <i class="fas fa-eye mr-3"></i> Lihat Detail
                                                        </a>
                                                        <a href="#" onclick="openMemorizationModal(); return false;" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-200">
                                                            <i class="fas fa-book-open mr-3"></i> Lihat Hafalan
                                                        </a>
                                                        <div class="border-t border-gray-100"></div>
                                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                                                            <i class="fas fa-user-minus mr-3"></i> Keluarkan dari Program
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-users text-4xl text-green-400 mb-4"></i>
                        <p class="text-gray-600 mb-4">Belum ada siswa yang terdaftar dalam program ini</p>
                        <button onclick="openAddStudentModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i> Tambah Siswa
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal Tambah Siswa -->
<div id="addStudentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 99999;">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-white rounded-xl shadow-2xl border border-gray-200 transform transition-all duration-300">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-user-plus mr-3 text-green-600"></i>
                    Tambah Siswa
                </h3>
                <button onclick="closeAddStudentModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <form action="{{ route('admin.programs.students.store', $program->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="student_name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-green-600"></i>Nama Siswa
                        </label>
                        <input type="text" id="student_name" name="name" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                               placeholder="Masukkan nama siswa">
                    </div>
                    <div>
                        <label for="student_email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-600"></i>Email
                        </label>
                        <input type="email" id="student_email" name="email" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                               placeholder="contoh@email.com">
                    </div>
                    <div>
                        <label for="student_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-green-600"></i>No. Telepon
                        </label>
                        <input type="text" id="student_phone" name="phone" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeAddStudentModal()" 
                                class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kelola Siswa -->
<div id="manageStudentsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 99999;">
    <div class="flex min-h-screen items-start justify-center p-4 pt-8">
        <div class="relative w-full max-w-6xl bg-white rounded-xl shadow-2xl border border-gray-200 transform transition-all duration-300">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users-cog mr-3 text-green-600"></i>
                    Kelola Siswa Program
                </h3>
                <button onclick="closeManageStudentsModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <!-- Action Button -->
                <div class="mb-6">
                    <button onclick="openAddStudentModal(); closeManageStudentsModal();" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i> Tambah Siswa Baru
                    </button>
                </div>
                
                <!-- Table Container with proper responsive design -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($program->students ?? [] as $student)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Aktif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 px-2 py-1 rounded hover:bg-indigo-50 transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="text-red-600 hover:text-red-900 px-2 py-1 rounded hover:bg-red-50 transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        <i class="fas fa-users text-3xl text-gray-300 mb-2 block"></i>
                                        Belum ada siswa yang terdaftar
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lihat Hafalan -->
<div id="memorizationModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full" style="z-index: 99999;">
    <div class="flex min-h-screen items-start justify-center p-4 pt-8">
        <div class="relative w-full max-w-6xl bg-white rounded-xl shadow-2xl border border-gray-200 transform transition-all duration-300">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 rounded-t-xl">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-book-open mr-3 text-green-600"></i>
                    Data Hafalan Siswa
                </h3>
                <button onclick="closeMemorizationModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-2 transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <!-- Table Container with proper responsive design -->
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juz</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($program->hafalans ?? [] as $hafalan)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                            {{ $hafalan->student->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-book mr-1"></i>Juz {{ $hafalan->juz_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php $progress = $hafalan->progress ?? 0; @endphp
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500 font-medium min-w-[40px]">{{ $progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $progress >= 100 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            <i class="fas {{ $progress >= 100 ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                                            {{ $progress >= 100 ? 'Selesai' : 'Dalam Progress' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3 px-2 py-1 rounded hover:bg-indigo-50 transition-colors duration-200">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </button>
                                        <button class="text-green-600 hover:text-green-900 px-2 py-1 rounded hover:bg-green-50 transition-colors duration-200">
                                            <i class="fas fa-clipboard-check mr-1"></i>Evaluasi
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                        <i class="fas fa-book-open text-3xl text-gray-300 mb-2 block"></i>
                                        Belum ada data hafalan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Modal Styles */
.modal-overlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
    z-index: 99999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.modal-content {
    background: white !important;
    border-radius: 12px !important;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    max-height: 90vh !important;
    overflow-y: auto !important;
}

/* Ensure modals are above everything */
#addStudentModal,
#manageStudentsModal,
#memorizationModal {
    z-index: 99999 !important;
}
</style>
@endpush

@push('scripts')
<script>
// Ensure DOM is fully loaded before executing scripts
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing modal functions...');
    
    // Progress bar animation
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = width;
        }, 100);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Initialize DataTables if jQuery is available
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#studentsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 10,
            "responsive": true,
            "order": [[1, "asc"]]
        });
    }

    // Test modal elements existence
    const addModal = document.getElementById('addStudentModal');
    const manageModal = document.getElementById('manageStudentsModal');
    const memorizationModal = document.getElementById('memorizationModal');
    
    console.log('Modal elements found:', {
        addModal: !!addModal,
        manageModal: !!manageModal,
        memorizationModal: !!memorizationModal
    });
});

// Global modal functions
window.toggleDropdown = function(index) {
    const dropdown = document.getElementById('dropdown-' + index);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(el) {
            if (el.id !== 'dropdown-' + index) {
                el.classList.add('hidden');
            }
        });
    }
};

// Enhanced Modal Functions
function openAddStudentModal() {
    console.log('Opening add student modal');
    const modal = document.getElementById('addStudentModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scroll
        console.log('Modal opened successfully');
    } else {
        console.error('Modal not found');
    }
}

function closeAddStudentModal() {
    console.log('Closing add student modal');
    const modal = document.getElementById('addStudentModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Modal closed successfully');
    }
}

function openManageStudentsModal() {
    console.log('Opening manage students modal');
    const modal = document.getElementById('manageStudentsModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        console.log('Manage students modal opened successfully');
    } else {
        console.error('Manage students modal not found');
    }
}

function closeManageStudentsModal() {
    console.log('Closing manage students modal');
    const modal = document.getElementById('manageStudentsModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Manage students modal closed successfully');
    }
}

function openMemorizationModal() {
    console.log('Opening memorization modal');
    const modal = document.getElementById('memorizationModal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        console.log('Memorization modal opened successfully');
    } else {
        console.error('Memorization modal not found');
    }
}

function closeMemorizationModal() {
    console.log('Closing memorization modal');
    const modal = document.getElementById('memorizationModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Memorization modal closed successfully');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick^="toggleDropdown"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(el) {
            el.classList.add('hidden');
        });
    }
});

// Toggle user menu
window.toggleUserMenu = function() {
    const menu = document.getElementById('userMenu');
    if (menu) {
        menu.classList.toggle('hidden');
    }
};

// Close user menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('userMenu');
    const button = event.target.closest('button');
    
    if (menu && (!button || !button.onclick || button.onclick.toString().indexOf('toggleUserMenu') === -1)) {
        menu.classList.add('hidden');
    }
});

// Assign enhanced functions to window object for global access
window.openAddStudentModal = openAddStudentModal;
window.closeAddStudentModal = closeAddStudentModal;
window.openManageStudentsModal = openManageStudentsModal;
window.closeManageStudentsModal = closeManageStudentsModal;
window.openMemorizationModal = openMemorizationModal;
window.closeMemorizationModal = closeMemorizationModal;

// Close modals when clicking outside
window.onclick = function(event) {
    const addModal = document.getElementById('addStudentModal');
    const manageModal = document.getElementById('manageStudentsModal');
    const memorizationModal = document.getElementById('memorizationModal');
    
    if (event.target === addModal) {
        closeAddStudentModal();
    }
    if (event.target === manageModal) {
        closeManageStudentsModal();
    }
    if (event.target === memorizationModal) {
        closeMemorizationModal();
    }
};

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAddStudentModal();
        closeManageStudentsModal();
        closeMemorizationModal();
    }
});
</script>
@endpush
