@extends('layouts.app')

@section('title', 'Tambah Program Baru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600 transition-colors">Dashboard</a></li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('admin.programs.index') }}" class="hover:text-green-600 transition-colors">Program</a>
            </li>
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900 dark:text-gray-200">Tambah Program</span>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-6 mb-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl font-bold">Tambah Program Baru</h1>
                <p class="text-green-100">Buat program hafalan Al-Qur'an baru</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Program</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.programs.store') }}" id="programForm" class="space-y-6">
                        @csrf
                        
                        <!-- Nama Program -->
                        <div>
                            <label for="nama" class="form-label">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama') }}" 
                                   required 
                                   class="form-input @error('nama') border-red-500 @enderror"
                                   placeholder="Masukkan nama program hafalan">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Program -->
                        <div>
                            <label for="jenis" class="form-label">
                                Jenis Program <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis" 
                                    name="jenis" 
                                    required 
                                    class="form-input @error('jenis') border-red-500 @enderror">
                                <option value="">Pilih jenis program</option>
                                <option value="reguler" {{ old('jenis') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="khusus" {{ old('jenis') == 'khusus' ? 'selected' : '' }}>Khusus</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Program reguler untuk siswa umum, khusus untuk siswa pilihan</p>
                        </div>

                        <!-- Guru Pembimbing -->
                        <div>
                            <label for="guru_id" class="form-label">
                                Guru Pembimbing
                            </label>
                            <select id="guru_id" 
                                    name="guru_id" 
                                    class="form-input @error('guru_id') border-red-500 @enderror">
                                <option value="">Pilih guru pembimbing</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Opsional: Guru yang akan membimbing program ini</p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="form-label">
                                Deskripsi Program
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      class="form-input @error('deskripsi') border-red-500 @enderror"
                                      placeholder="Jelaskan tujuan dan detail program hafalan ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-sm mt-1">Opsional: Berikan penjelasan singkat tentang program ini</p>
                        </div>

                        <!-- Target Juz -->
                        <div>
                            <label class="form-label">
                                Target Juz (Opsional)
                            </label>
                            <div class="bg-gray-50 rounded-lg border border-gray-200">
                                <div class="p-6">
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">Pilih juz yang akan menjadi target dalam program ini:</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-3">
                                        @for($i = 1; $i <= 30; $i++)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       name="juz_targets[]" 
                                                       value="{{ $i }}" 
                                                       id="juz_{{ $i }}"
                                                       {{ in_array($i, old('juz_targets', [])) ? 'checked' : '' }}
                                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                                                <label class="ml-2 text-sm text-gray-700 dark:text-gray-300" for="juz_{{ $i }}">
                                                    Juz {{ $i }}
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-green-300 shadow-sm text-sm leading-4 font-medium rounded-md text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-gray-700 dark:border-green-600 dark:text-green-300 dark:hover:bg-gray-600" id="selectAllJuz">
                                            Pilih Semua
                                        </button>
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600" id="clearAllJuz">
                                            Hapus Semua
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">Anda dapat menambah atau mengubah target juz setelah program dibuat</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-between pt-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Simpan Program
                            </button>
                            <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h6 class="text-lg font-semibold">Tips Membuat Program</h6>
                </div>
                <div class="p-6">
                    <h6 class="font-semibold text-gray-900 dark:text-white mb-3">Tips Membuat Program:</h6>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 mb-4 space-y-1">
                        <li>• Gunakan nama yang jelas dan mudah dipahami</li>
                        <li>• Pilih jenis program sesuai kebutuhan</li>
                        <li>• Target juz dapat disesuaikan kemudian</li>
                        <li>• Guru pembimbing bersifat opsional</li>
                    </ul>
                    
                    <h6 class="font-semibold text-gray-900 dark:text-white mb-3">Jenis Program:</h6>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li><strong class="text-gray-900 dark:text-white">Reguler:</strong> Program umum untuk semua siswa</li>
                        <li><strong class="text-gray-900 dark:text-white">Khusus:</strong> Program untuk siswa pilihan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all/none juz targets
    const selectAllBtn = document.getElementById('selectAllJuz');
    const clearAllBtn = document.getElementById('clearAllJuz');
    const juzCheckboxes = document.querySelectorAll('input[name="juz_targets[]"]');
    
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            juzCheckboxes.forEach(checkbox => checkbox.checked = true);
        });
    }
    
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function() {
            juzCheckboxes.forEach(checkbox => checkbox.checked = false);
        });
    }

    // Form validation
    const form = document.getElementById('programForm');
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