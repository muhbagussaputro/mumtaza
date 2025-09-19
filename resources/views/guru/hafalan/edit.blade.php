@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center">
                <a href="{{ route('guru.hafalan.index') }}" class="mr-3 hover:bg-green-700 p-2 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold">Edit Setoran</h1>
                    <p class="text-green-100 text-sm">{{ $memorization->student->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 py-4">
        <form action="{{ route('guru.hafalan.update', $memorization->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <!-- Student Info Card -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        @if($memorization->student->foto_path)
                            <img src="{{ asset('storage/' . $memorization->student->foto_path) }}" 
                                 alt="{{ $memorization->student->name }}" 
                                 class="w-12 h-12 rounded-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h3 class="font-semibold text-gray-900">{{ $memorization->student->name }}</h3>
                        <p class="text-sm text-gray-500">NIS: {{ $memorization->student->nis ?? '-' }}</p>
                        <p class="text-xs text-gray-500">Setoran: {{ $memorization->tanggal_setoran->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Hafalan Info -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Informasi Hafalan</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Surah:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $memorization->juzTarget->surah->name_id ?? 'Surah tidak ditemukan' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Juz:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $memorization->juzTarget->juz_ke ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Ayat:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $memorization->ayat_mulai }} - {{ $memorization->ayat_selesai }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ayat Range -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Edit Range Ayat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Mulai</label>
                        <input type="number" name="ayat_mulai" min="1" required 
                               value="{{ old('ayat_mulai', $memorization->ayat_mulai) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @error('ayat_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Selesai</label>
                        <input type="number" name="ayat_selesai" min="1" required 
                               value="{{ old('ayat_selesai', $memorization->ayat_selesai) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        @error('ayat_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status Hafalan -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-3">Status Hafalan</label>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="status_hafalan" value="lancar" 
                               {{ old('status_hafalan', $memorization->status_hafalan) == 'lancar' ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                        <span class="ml-3 text-sm text-gray-700">Lancar</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_hafalan" value="kurang_lancar" 
                               {{ old('status_hafalan', $memorization->status_hafalan) == 'kurang_lancar' ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                        <span class="ml-3 text-sm text-gray-700">Kurang Lancar</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_hafalan" value="tidak_lancar" 
                               {{ old('status_hafalan', $memorization->status_hafalan) == 'tidak_lancar' ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                        <span class="ml-3 text-sm text-gray-700">Tidak Lancar</span>
                    </label>
                </div>
                @error('status_hafalan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nilai -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100)</label>
                <input type="number" name="nilai" min="0" max="100" 
                       value="{{ old('nilai', $memorization->nilai) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                @error('nilai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Guru -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Guru</label>
                <textarea name="catatan_guru" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                          placeholder="Masukkan catatan untuk siswa...">{{ old('catatan_guru', $memorization->catatan_guru) }}</textarea>
                @error('catatan_guru')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Violations -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-3">Pelanggaran (Opsional)</label>
                <div class="space-y-2">
                    @foreach($violations as $violation)
                    <label class="flex items-center">
                        <input type="checkbox" name="violations[]" value="{{ $violation->id }}" 
                               {{ in_array($violation->id, old('violations', $memorization->violations->pluck('id')->toArray())) ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">{{ $violation->nama }}</span>
                    </label>
                    @if($violation->deskripsi)
                        <p class="ml-7 text-xs text-gray-500">{{ $violation->deskripsi }}</p>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex space-x-3 pb-6">
                <button type="submit" 
                        class="flex-1 bg-teal-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Update Setoran
                </button>
                <a href="{{ route('guru.hafalan.index') }}" 
                   class="flex-1 bg-gray-300 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection