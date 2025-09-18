@extends('layouts.app')

@section('title', 'Edit Program')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm font-medium text-gray-600">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-green-600 transition-colors duration-200">
                    Dashboard
                </a>
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.programs.index') }}" class="hover:text-green-600 transition-colors duration-200">
                    Program
                </a>
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 font-semibold">Edit Program</span>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-8 mb-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-white">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Program
                </h1>
                <p class="mt-2 text-lg text-green-100">
                    Edit data program {{ $program->nama }}
                </p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 hover:shadow-xl transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                    <h3 class="text-base font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-edit mr-2 text-green-500"></i> Edit Informasi Program
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" id="editProgramForm" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nama Program -->
                        <div class="mb-6">
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $program->nama) }}" 
                                   required 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 placeholder-gray-500 @error('nama') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="Masukkan nama program hafalan">
                            @error('nama')
                                <p class="text-red-500 text-sm font-medium mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Jenis Program -->
                        <div class="mb-6">
                            <label for="jenis" class="block text-sm font-semibold text-gray-700 mb-3">
                                Jenis Program <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis" 
                                    name="jenis" 
                                    required 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 bg-white @error('jenis') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="" class="text-gray-500">Pilih Jenis Program</option>
                                <option value="Tahfidz" {{ old('jenis', $program->jenis) == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                                <option value="Muraja'ah" {{ old('jenis', $program->jenis) == "Muraja'ah" ? 'selected' : '' }}>Muraja'ah</option>
                                <option value="Ziyadah" {{ old('jenis', $program->jenis) == 'Ziyadah' ? 'selected' : '' }}>Ziyadah</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm font-medium mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-gray-600 text-sm font-medium mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Pilih jenis program hafalan yang sesuai
                            </p>
                        </div>

                        <!-- Guru Pembimbing -->
                        <div class="mb-6">
                            <label for="guru_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                Guru Pembimbing
                            </label>
                            <select id="guru_id" 
                                    name="guru_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 bg-white @error('guru_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">
                                <option value="" class="text-gray-500">Pilih guru pembimbing</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('guru_id', $program->guru_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <p class="text-red-500 text-sm font-medium mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-gray-600 text-sm font-medium mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Opsional: Guru yang akan membimbing program ini
                            </p>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-3">
                                Deskripsi Program
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-gray-900 placeholder-gray-500 resize-vertical @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                      placeholder="Jelaskan tujuan dan detail program hafalan ini...">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm font-medium mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-gray-600 text-sm font-medium mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Opsional: Berikan penjelasan singkat tentang program ini
                            </p>
                        </div>

                        <!-- Target Juz -->
                        <div>
                            <label class="form-label">
                                Target Juz <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-green-50 rounded-xl p-6 mb-8">
                                <h3 class="text-base font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-bullseye mr-2 text-green-600"></i>
                                    Target Juz <span class="text-red-500">*</span>
                                </h3>
                                <p class="text-gray-700 text-sm font-medium mb-6">Pilih juz yang akan menjadi target dalam program ini. Minimal pilih 1 juz.</p>

                                <!-- Bulk Actions -->
                                <div class="flex flex-wrap gap-3 mb-6">
                                    <button type="button" id="selectAll" 
                                            class="px-5 py-2.5 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-check-double mr-2"></i>
                                        Pilih Semua
                                    </button>
                                    <button type="button" id="deselectAll" 
                                            class="px-5 py-2.5 bg-gray-500 text-white text-sm font-semibold rounded-lg hover:bg-gray-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-times mr-2"></i>
                                        Hapus Semua
                                    </button>
                                </div>
                                <!-- Juz Selection Container -->
                                <div class="bg-white rounded-lg border border-gray-200 p-4">
                                    <p class="text-gray-600 text-sm font-medium mb-4 flex items-center">
                                        <i class="fas fa-hand-pointer mr-2 text-blue-500"></i>
                                        Pilih juz yang akan menjadi target hafalan dalam program ini:
                                    </p>
                                    
                                    <!-- Scrollable Grid Container -->
                                    <div class="overflow-x-auto">
                                        <div class="min-w-full">
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 min-w-max">
                                                @php
                                                    $currentTargets = $program->juzTargets->pluck('juz_number')->toArray();
                                                @endphp
                                                @for($i = 1; $i <= 30; $i++)
                                                    <div class="flex items-center whitespace-nowrap bg-gray-50 hover:bg-green-50 rounded-lg p-3 transition-colors duration-200 border border-gray-200 hover:border-green-300">
                                                        <input type="checkbox" 
                                                               name="juz_targets[]" 
                                                               value="{{ $i }}" 
                                                               id="juz_{{ $i }}"
                                                               {{ in_array($i, old('juz_targets', $currentTargets)) ? 'checked' : '' }}
                                                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors duration-200">
                                                        <label class="ml-3 text-sm font-medium text-gray-700 cursor-pointer select-none" for="juz_{{ $i }}">
                                                            Juz {{ $i }}
                                                        </label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Scroll Hint -->
                                    <div class="mt-3 text-xs text-gray-500 flex items-center justify-center lg:hidden">
                                        <i class="fas fa-arrows-alt-h mr-2"></i>
                                        Geser ke kiri/kanan untuk melihat lebih banyak pilihan
                                    </div>
                                </div>
                                
                                @error('juz_targets')
                                    <p class="text-red-500 text-sm font-medium mt-3 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="flex justify-center space-x-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Program
                                </button>
                                <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 hover:shadow-xl transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                    <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-green-500"></i>
                        Informasi Program
                    </h6>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-semibold text-gray-600">Status:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-bold rounded-full 
                                {{ $program->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600">Dibuat:</span>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $program->created_at->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600">Terakhir diupdate:</span>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $program->updated_at->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600">Total Siswa:</span>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $program->students->count() }} siswa</span>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-600">Target Juz:</span>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $program->juzTargets->count() }} juz</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50 rounded-t-xl">
                    <h6 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-lightbulb mr-2 text-green-500"></i>
                        Tips Edit Program
                    </h6>
                </div>
                <div class="p-6">
                    <ul class="space-y-4 text-sm text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-sm"></i>
                            <span class="font-medium">Pastikan nama program jelas dan mudah dipahami</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-sm"></i>
                            <span class="font-medium">Pilih jenis program sesuai dengan tujuan pembelajaran</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-sm"></i>
                            <span class="font-medium">Minimal pilih 1 juz sebagai target hafalan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-sm"></i>
                            <span class="font-medium">Deskripsi program membantu siswa memahami tujuan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all/none juz targets
    const selectAllBtn = document.getElementById('selectAll');
    const clearAllBtn = document.getElementById('deselectAll');
    const juzCheckboxes = document.querySelectorAll('input[name="juz_targets[]"]');
    
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            juzCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
                // Add visual feedback
                checkbox.closest('div').classList.add('bg-green-100', 'border-green-400');
                checkbox.closest('div').classList.remove('bg-gray-50', 'border-gray-200');
            });
        });
    }
    
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            juzCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                // Remove visual feedback
                checkbox.closest('div').classList.remove('bg-green-100', 'border-green-400');
                checkbox.closest('div').classList.add('bg-gray-50', 'border-gray-200');
            });
        });
    }
    
    // Add individual checkbox change handlers for visual feedback
    juzCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('div');
            if (this.checked) {
                container.classList.add('bg-green-100', 'border-green-400');
                container.classList.remove('bg-gray-50', 'border-gray-200');
            } else {
                container.classList.remove('bg-green-100', 'border-green-400');
                container.classList.add('bg-gray-50', 'border-gray-200');
            }
        });
        
        // Set initial state
        const container = checkbox.closest('div');
        if (checkbox.checked) {
            container.classList.add('bg-green-100', 'border-green-400');
            container.classList.remove('bg-gray-50', 'border-gray-200');
        }
    });

    // Form validation
    const form = document.getElementById('editProgramForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const jenis = document.getElementById('jenis').value;
            
            if (!nama) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Nama program harus diisi!'
                });
                document.getElementById('nama').focus();
                return;
            }
            
            if (!jenis) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Jenis program harus dipilih!'
                });
                document.getElementById('jenis').focus();
                return;
            }
        });
    }
});
</script>

@endsection