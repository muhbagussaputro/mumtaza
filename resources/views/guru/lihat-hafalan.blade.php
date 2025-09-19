@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('guru.siswa.show', $student) }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">{{ $student->name }}</h1>
                        <p class="text-teal-100 text-sm">Data Hafalan</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('guru.setoran.create', ['student' => $student->id, 'programId' => $programId]) }}" 
                       class="px-3 py-2 bg-white text-teal-600 rounded-lg text-sm font-medium hover:bg-gray-50">
                        + Tambah Setoran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('guru.siswa.hafalan', $student) }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                    <select name="program_id" id="program_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Semua Program</option>
                        @foreach($studentPrograms as $studentProgram)
                            <option value="{{ $studentProgram->program_id }}" {{ $programId == $studentProgram->program_id ? 'selected' : '' }}>
                                {{ $studentProgram->program->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700">
                        Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Memorization Entries -->
    <div class="px-4 pb-6">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Hafalan</h3>
                <p class="text-sm text-gray-600">Total: {{ $entries->count() }} setoran</p>
            </div>

            @if($entries->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($entries as $entry)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Juz {{ $entry->juz_number }}
                                        </span>
                                        <span class="ml-2 text-sm text-gray-500">
                                            {{ $entry->surah->name_id ?? 'Surah tidak ditemukan' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-1">
                                        @if($entry->halaman)
                                            Halaman {{ $entry->halaman }}
                                        @endif
                                        @if($entry->ayat)
                                            Ayat {{ $entry->ayat }}
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $entry->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    @if($entry->notes)
                                        <div class="mt-2 text-sm text-gray-600 italic">
                                            "{{ $entry->notes }}"
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right ml-4">
                                    <div class="mb-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($entry->klasifikasi == 'tercapai') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $entry->klasifikasi)) }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-1">
                                        {{ ucfirst($entry->jadwal_setoran) }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ ucfirst(str_replace('_', ' ', $entry->jenis_setoran)) }}
                                    </div>
                                    @if($entry->hadir)
                                        <div class="text-xs text-green-600 mt-1">
                                            ✓ Hadir
                                        </div>
                                    @else
                                        <div class="text-xs text-red-600 mt-1">
                                            ✗ Tidak Hadir
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($entry->violations->count() > 0)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="text-sm text-gray-600 mb-1">Pelanggaran:</div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($entry->violations as $violation)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ $violation->violation->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-3 flex justify-end space-x-2">
                                <a href="{{ route('guru.hafalan.show', $entry) }}" 
                                   class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                                    Detail
                                </a>
                                <a href="{{ route('guru.setoran.edit', $entry) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Edit
                                </a>
                                <form action="{{ route('guru.setoran.destroy', $entry) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus setoran ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                        <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172zM11 6a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-gray-500">Belum ada data hafalan untuk siswa ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection