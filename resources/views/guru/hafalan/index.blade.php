@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('guru.dashboard') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Data Hafalan</h1>
                        <p class="text-teal-100 text-sm">Kelola setoran hafalan siswa</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('guru.siswa.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-teal-600 rounded-lg hover:bg-teal-50 border border-teal-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Setoran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('guru.hafalan.index') }}">
                <div class="space-y-3">
                    <div class="flex gap-2">
                        <select name="student_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="">Semua Siswa</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex gap-2">
                        <select name="klasifikasi" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="">Semua Status</option>
                            <option value="tercapai" {{ request('klasifikasi') == 'tercapai' ? 'selected' : '' }}>Tercapai</option>
                            <option value="belum_tercapai" {{ request('klasifikasi') == 'belum_tercapai' ? 'selected' : '' }}>Belum Tercapai</option>
                        </select>
                        
                        <select name="program_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                            <option value="">Semua Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Memorizations Table -->
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            @if($entries->count() > 0)
                <table id="hafalanTable" class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juz</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ayat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($entries as $entry)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-3">
                                        @if($entry->student->foto_path)
                                            <img src="{{ asset('storage/' . $entry->student->foto_path) }}" 
                                                 alt="{{ $entry->student->name }}" 
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $entry->student->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $entry->surah->name_id ?? 'Surah tidak ditemukan' }}
                                </div>
                                @if($entry->catatan_guru)
                                    <div class="text-xs text-gray-500 italic mt-1">"{{ Str::limit($entry->catatan_guru, 50) }}"</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $entry->juz_number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $entry->ayat_mulai }} - {{ $entry->ayat_selesai }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($entry->klasifikasi == 'tercapai') bg-green-100 text-green-800
                                    @elseif($entry->klasifikasi == 'belum_tercapai') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $entry->klasifikasi)) }}
                                </span>
                                @if($entry->violations && $entry->violations->count() > 0)
                                    <div class="mt-1">
                                        @foreach($entry->violations->take(2) as $violation)
                                            <span class="inline-flex items-center px-1 py-0.5 rounded text-xs bg-red-100 text-red-800 mr-1">
                                                {{ Str::limit($violation->nama, 10) }}
                                            </span>
                                        @endforeach
                                        @if($entry->violations->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $entry->violations->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $entry->nilai ? $entry->nilai . '/100' : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $entry->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('guru.setoran.edit', $entry->id) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('guru.setoran.destroy', $entry->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus setoran ini?')"
                                                class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                        <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172zM11 6a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data hafalan</h3>
                <p class="text-gray-500 text-sm">Belum ada setoran hafalan yang tercatat</p>
            </div>
        @endif
    </div>
</div>

<script>
$(document).ready(function() {
    $('#hafalanTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
        },
        "pageLength": 15,
        "lengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Semua"]],
        "order": [[6, "desc"]], // Sort by date column
        "columnDefs": [
            { "orderable": false, "targets": [7] }, // Disable sorting for action column
            { "searchable": false, "targets": [7] }  // Disable search for action column
        ],
        "responsive": true,
        "dom": '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"mb-2 sm:mb-0"l><"mb-2 sm:mb-0"f>>rtip',
        "initComplete": function() {
            // Custom styling for DataTables elements
            $('.dataTables_length select').addClass('form-select text-sm border-gray-300 rounded-md');
            $('.dataTables_filter input').addClass('form-input text-sm border-gray-300 rounded-md');
            $('.dataTables_paginate .paginate_button').addClass('px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50');
            $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-500 text-white border-blue-500');
        }
    });
});
</script>
@endsection