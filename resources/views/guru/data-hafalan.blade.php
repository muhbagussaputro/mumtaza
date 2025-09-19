@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-green-200 bg-gradient-to-r from-green-50 to-green-100">
            <h2 class="text-xl font-semibold text-green-800">Data Hafalan</h2>
        </div>
        
        <div class="p-6">
            @if($entries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200 datatable responsive-table">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Siswa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Surah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Juz
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Ayat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Nilai
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">
                                    Tanggal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($entries as $entry)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                @if($entry->student->foto_path)
                                                    <img src="{{ asset('storage/' . $entry->student->foto_path) }}" 
                                                         alt="{{ $entry->student->name }}" 
                                                         class="w-10 h-10 rounded-full object-cover">
                                                @else
                                                    <span class="text-green-600 font-semibold text-sm">
                                                        {{ strtoupper(substr($entry->student->name, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $entry->student->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->surah->name_arabic ?? 'Surah tidak ditemukan' }}
                                        <div class="text-xs text-gray-500">{{ $entry->surah->name_latin ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->juz_number ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->ayat_mulai }} - {{ $entry->ayat_selesai }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($entry->keterangan == 'Lulus') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $entry->keterangan }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry->nilai ? $entry->nilai . '/100' : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $entry->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data hafalan</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada data hafalan yang tersedia.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/responsive-datatable.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 1 },
                { responsivePriority: 3, targets: 4 }
            ]
        });
    });
</script>
@endpush