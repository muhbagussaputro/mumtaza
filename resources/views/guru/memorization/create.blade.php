@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center">
                <a href="{{ route('guru.siswa.show', $student->id) }}" class="mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold">Input Hafalan</h1>
                    <p class="text-teal-100 text-sm">{{ $student->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 py-4">
        <form action="{{ route('guru.memorization.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            
            <!-- Student Info Card -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        @if($student->foto_path)
                            <img src="{{ asset('storage/' . $student->foto_path) }}" alt="{{ $student->name }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h3 class="font-semibold text-gray-900">{{ $student->name }}</h3>
                        <p class="text-sm text-gray-500">NIS: {{ $student->nis ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Program Selection -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="program_id" id="program_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Program</option>
                    @foreach($studentPrograms as $studentProgram)
                        <option value="{{ $studentProgram->program_id }}" 
                                {{ $selectedProgram && $selectedProgram->program_id == $studentProgram->program_id ? 'selected' : '' }}>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <select name="waktu" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Waktu</option>
                    <option value="pagi">Pagi</option>
                    <option value="sore">Sore</option>
                    <option value="malam">Malam</option>
                </select>
                @error('waktu')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kehadiran -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kehadiran</label>
                <select name="kehadiran" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Kehadiran</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                </select>
                @error('kehadiran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Surah Selection with Select2 -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Surah</label>
                <select name="id_surat" id="surah_select" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Surah</option>
                    @foreach($surahs as $surah)
                        <option value="{{ $surah->id }}">
                            {{ $surah->number }}. {{ $surah->name_ar }} ({{ $surah->name_id }})
                        </option>
                    @endforeach
                </select>
                @error('id_surat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ayat Range -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Mulai</label>
                        <input type="text" name="ayat_mulai" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="1">
                        @error('ayat_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Selesai</label>
                        <input type="text" name="ayat_selesai" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="10">
                        @error('ayat_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Jenis Hafalan -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Hafalan</label>
                <select name="jenis_hafalan" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Jenis Hafalan</option>
                    <option value="Tambah hafalan">Tambah hafalan</option>
                    <option value="Murojaah Qorib">Murojaah Qorib</option>
                    <option value="Murojaah Bid">Murojaah Bid</option>
                </select>
                @error('jenis_hafalan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Target</label>
                <select name="target" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Target</option>
                    <option value="tercapai">Tercapai</option>
                    <option value="tidak tercapai">Tidak Tercapai</option>
                </select>
                @error('target')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <select name="keterangan" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Keterangan</option>
                    <option value="lancar">Lancar</option>
                    <option value="tidak lancar">Tidak Lancar</option>
                </select>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komentar -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                <textarea name="komentar" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                          placeholder="Masukkan komentar..."></textarea>
                @error('komentar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pelanggaran -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggaran</label>
                <select name="pelanggaran" id="pelanggaran" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Pilih Pelanggaran</option>
                    <option value="ya">Ya</option>
                    <option value="tidak">Tidak</option>
                </select>
                @error('pelanggaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan Pelanggaran -->
            <div class="bg-white rounded-lg shadow-sm p-4" id="ket_pelanggaran_div" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Pelanggaran</label>
                <textarea name="ket_pelanggaran" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                          placeholder="Jelaskan pelanggaran yang terjadi..."></textarea>
                @error('ket_pelanggaran')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Halaman -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Halaman</label>
                <input type="text" name="halaman" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                       placeholder="Contoh: 1-5">
                @error('halaman')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex space-x-3">
                    <button type="submit" 
                            class="flex-1 bg-teal-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-teal-700 transition duration-200">
                        Simpan Hafalan
                    </button>
                    <a href="{{ route('guru.siswa.show', $student->id) }}" 
                       class="flex-1 bg-gray-500 text-white py-3 px-4 rounded-lg font-medium hover:bg-gray-600 transition duration-200 text-center">
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

    // Show/hide keterangan pelanggaran based on pelanggaran selection
    $('#pelanggaran').change(function() {
        if ($(this).val() === 'ya') {
            $('#ket_pelanggaran_div').show();
        } else {
            $('#ket_pelanggaran_div').hide();
            $('textarea[name="ket_pelanggaran"]').val('');
        }
    });
});
</script>
@endpush
@endsection