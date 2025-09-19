@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
        <p class="text-gray-600">Kelola data siswa dan hafalan mereka</p>
    </div>

    <div class="bg-white rounded-lg shadow-md border-t-4 border-green-500">
        <div class="p-6">
            <div class="mb-4">
                <label for="program-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Program</label>
                <select id="program-filter" class="form-input w-full max-w-xs focus:border-green-500 focus:ring-green-500">
                    <option value="">Semua Program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                    @endforeach
                </select>
            </div>

        <!-- Data Siswa -->
        @if($students->count() > 0)
            <div class="overflow-hidden">
                <x-responsive-datatable>
                    <x-slot name="mobileCards">
                        @foreach($students as $student)
                            <div class="bg-white border rounded-lg p-4 mb-3 shadow-sm border-l-4 border-green-300 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-green-800">{{ $student->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $student->nis ?? '-' }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                        {{ $student->kelas->name ?? 'Belum ada kelas' }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Program:</span>
                                        <span class="font-medium text-green-700">{{ $student->program->nama ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Progress:</span>
                                        <span class="font-medium text-green-700">{{ $student->memorizations_count ?? 0 }} setoran</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium text-green-600 bg-green-100 px-2 py-1 rounded">Aktif</span>
                                    </div>
                                </div>
                                <div class="mt-3 flex space-x-2">
                                    <a href="{{ route('guru.siswa.show', $student) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                        Detail
                                    </a>
                                    <a href="{{ route('guru.siswa.hafalan', $student) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                        Hafalan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </x-slot>

                <table id="studentsTable" class="display" style="width:100%">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="text-green-800 font-semibold">Nama</th>
                                <th class="text-green-800 font-semibold">NIS</th>
                                <th class="text-green-800 font-semibold">Kelas</th>
                                <th class="text-green-800 font-semibold">Program</th>
                                <th class="text-green-800 font-semibold">Progress</th>
                                <th class="text-green-800 font-semibold">Status</th>
                                <th class="text-green-800 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="font-medium text-green-800">{{ $student->name }}</td>
                                    <td>{{ $student->nis ?? '-' }}</td>
                                    <td>{{ $student->kelas->name ?? 'Belum ada kelas' }}</td>
                                    <td class="text-green-700">{{ $student->program->nama ?? '-' }}</td>
                                    <td class="text-green-700 font-medium">{{ $student->memorizations_count ?? 0 }} setoran</td>
                                    <td><span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">Aktif</span></td>
                                    <td>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('guru.siswa.show', $student) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                                Detail
                                            </a>
                                            <a href="{{ route('guru.siswa.hafalan', $student) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                                Hafalan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-responsive-datatable>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg mb-4">
                    <i class="fas fa-users text-4xl mb-4"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data siswa</h3>
                <p class="text-gray-500">
                    @if($programId)
                        Tidak ada siswa yang terdaftar dalam program yang dipilih.
                    @else
                        Belum ada siswa yang terdaftar dalam sistem.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/responsive-datatable.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('#studentsTable').DataTable({
            pageLength: 15,
            lengthMenu: [[5, 10, 15, 25, 50, -1], [5, 10, 15, 25, 50, "All"]],
            order: [[0, 'asc']],
            responsive: true,
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 },
                { responsivePriority: 3, targets: 1 }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: "Tidak ada data yang tersedia",
                zeroRecords: "Tidak ada data yang cocok"
            }
        });

        $('#program-filter').on('change', function() {
            var programId = $(this).val();
            if (programId) {
                table.column(3).search('^' + programId + '$', true, false).draw();
            } else {
                table.column(3).search('').draw();
            }
        });
    });
</script>
@endpush