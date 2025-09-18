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
                    <h1 class="text-xl font-bold">Form Setoran</h1>
                    <p class="text-teal-100 text-sm">{{ $student->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="px-4 py-4">
        <form action="{{ route('guru.hafalan.store') }}" method="POST" class="space-y-4">
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
                    @foreach($student->studentPrograms as $studentProgram)
                        <option value="{{ $studentProgram->program_id }}" 
                                data-juz-targets="{{ json_encode($studentProgram->program->juzTargets) }}">
                            {{ $studentProgram->program->nama }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Juz Target Selection -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Target Juz</label>
                <select name="juz_target_id" id="juz_target_id" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent" disabled>
                    <option value="">Pilih program terlebih dahulu</option>
                </select>
                @error('juz_target_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ayat Range -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Mulai</label>
                        <input type="number" name="ayat_mulai" min="1" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="1">
                        @error('ayat_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ayat Selesai</label>
                        <input type="number" name="ayat_selesai" min="1" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                               placeholder="10">
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
                        <input type="radio" name="status_hafalan" value="lancar" required 
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                        <span class="ml-3 text-sm text-gray-700">Lancar</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_hafalan" value="kurang_lancar" 
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300">
                        <span class="ml-3 text-sm text-gray-700">Kurang Lancar</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_hafalan" value="tidak_lancar" 
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
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                       placeholder="85">
                @error('nilai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Guru -->
            <div class="bg-white rounded-lg shadow-sm p-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Guru</label>
                <textarea name="catatan_guru" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                          placeholder="Masukkan catatan untuk siswa..."></textarea>
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
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">{{ $violation->nama }}</span>
                    </label>
                    @if($violation->deskripsi)
                        <p class="ml-7 text-xs text-gray-500">{{ $violation->deskripsi }}</p>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pb-6">
                <button type="submit" 
                        class="w-full bg-teal-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Simpan Setoran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const programSelect = document.getElementById('program_id');
    const juzTargetSelect = document.getElementById('juz_target_id');
    
    programSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const juzTargets = selectedOption.dataset.juzTargets ? JSON.parse(selectedOption.dataset.juzTargets) : [];
        
        // Clear juz target options
        juzTargetSelect.innerHTML = '<option value="">Pilih Target Juz</option>';
        
        if (juzTargets.length > 0) {
            juzTargetSelect.disabled = false;
            juzTargets.forEach(function(juzTarget) {
                const option = document.createElement('option');
                option.value = juzTarget.id;
                option.textContent = `Juz ${juzTarget.juz_ke} - ${juzTarget.surah ? juzTarget.surah.name_id : 'Surah tidak ditemukan'}`;
                juzTargetSelect.appendChild(option);
            });
        } else {
            juzTargetSelect.disabled = true;
        }
    });
});
</script>
@endsection