@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center">
                <a href="{{ route('guru.siswa.show', $entry->student_id) }}" class="mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold">Edit Hafalan</h1>
                    <p class="text-teal-100 text-sm">{{ $entry->student->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 py-4">
        <!-- Required Field Legend -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
            <p class="text-sm text-blue-800">
                <span class="text-red-500">*</span> = Field wajib diisi
            </p>
        </div>
        
        <form action="{{ route('guru.setoran.update', $entry->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="student_id" value="{{ $entry->student_id }}">
            
            <!-- Student Info Card -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        @if($entry->student->foto_path)
                            <img src="{{ asset('storage/' . $entry->student->foto_path) }}" alt="{{ $entry->student->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h3 class="font-semibold text-gray-900">{{ $entry->student->name }}</h3>
                        <p class="text-sm text-gray-500">NIS: {{ $entry->student->nis ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Program Selection -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Program <span class="text-red-500">*</span>
                </label>
                <select name="program_id" id="program_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Program</option>
                    @foreach($studentPrograms as $studentProgram)
                        <option value="{{ $studentProgram->program->id }}" {{ $entry->program_id == $studentProgram->program->id ? 'selected' : '' }}>
                            {{ $studentProgram->program->nama }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Waktu -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Waktu <span class="text-red-500">*</span>
                </label>
                <select name="jadwal_setoran" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Waktu</option>
                    <option value="pagi" {{ $entry->jadwal_setoran == 'pagi' ? 'selected' : '' }}>Pagi</option>
                    <option value="siang" {{ $entry->jadwal_setoran == 'siang' ? 'selected' : '' }}>Siang</option>
                    <option value="malam" {{ $entry->jadwal_setoran == 'malam' ? 'selected' : '' }}>Malam</option>
                </select>
                @error('jadwal_setoran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kehadiran -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kehadiran <span class="text-red-500">*</span>
                </label>
                <select name="hadir" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Kehadiran</option>
                    <option value="1" {{ $entry->hadir ? 'selected' : '' }}>Hadir</option>
                    <option value="0" {{ !$entry->hadir ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
                @error('hadir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Surah Selection -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Surah <span class="text-red-500">*</span>
                </label>
                <select name="surah_id" id="surah_select" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Surah</option>
                    @foreach($surahs as $surah)
                        <option value="{{ $surah->id }}" {{ $entry->surah_id == $surah->id ? 'selected' : '' }}>
                            {{ $surah->number }}. {{ $surah->name_ar }} ({{ $surah->name_id }})
                        </option>
                    @endforeach
                </select>
                @error('surah_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ayat Range -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ayat <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="ayat" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="1" value="{{ $entry->ayat }}">
                        @error('ayat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Halaman
                        </label>
                        <input type="number" name="halaman" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="1" value="{{ $entry->halaman }}">
                        @error('halaman')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Jenis Hafalan -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Hafalan <span class="text-red-500">*</span>
                </label>
                <select name="jenis_setoran" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Jenis Hafalan</option>
                    <option value="tambah_hafalan" {{ $entry->jenis_setoran == 'tambah_hafalan' ? 'selected' : '' }}>Tambah hafalan</option>
                    <option value="murojaah_qorib" {{ $entry->jenis_setoran == 'murojaah_qorib' ? 'selected' : '' }}>Murojaah Qorib</option>
                    <option value="murojaah_bid" {{ $entry->jenis_setoran == 'murojaah_bid' ? 'selected' : '' }}>Murojaah Bid</option>
                </select>
                @error('jenis_setoran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Target <span class="text-red-500">*</span>
                </label>
                <select name="klasifikasi" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Target</option>
                    <option value="tercapai" {{ $entry->klasifikasi == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                    <option value="tidak_tercapai" {{ $entry->klasifikasi == 'tidak_tercapai' ? 'selected' : '' }}>Tidak Tercapai</option>
                </select>
                @error('klasifikasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan <span class="text-red-500">*</span>
                </label>
                <select name="keterangan" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Keterangan</option>
                    <option value="lancar" {{ $entry->keterangan == 'lancar' ? 'selected' : '' }}>Lancar</option>
                    <option value="tidak lancar" {{ $entry->keterangan == 'tidak lancar' ? 'selected' : '' }}>Tidak Lancar</option>
                </select>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komentar -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                <textarea name="notes" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                          placeholder="Masukkan komentar tambahan...">{{ $entry->notes }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Juz Number -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Juz <span class="text-red-500">*</span>
                </label>
                <input type="number" name="juz_number" required min="1" max="30"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                       placeholder="1-30" value="{{ $entry->juz_number }}">
                @error('juz_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Violations -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pelanggaran
                </label>
                <div class="space-y-2">
                    @foreach($violations as $violation)
                        <label class="flex items-center">
                            <input type="checkbox" name="violations[]" value="{{ $violation->id }}" 
                                   {{ $entry->violations->contains('violation_id', $violation->id) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $violation->nama }}</span>
                        </label>
                    @endforeach
                </div>
                @error('violations')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 bg-teal-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-teal-700 transition duration-200 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Update Hafalan
                    </button>
                    <a href="{{ route('guru.siswa.show', $entry->student_id) }}" 
                       class="flex-1 bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition duration-200 text-center focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for Surah selection
    $('#surah_select').select2({
        placeholder: 'Cari dan pilih surah...',
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush
@endsection