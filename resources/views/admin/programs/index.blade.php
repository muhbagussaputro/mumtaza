@extends('layouts.app')

@section('title', 'Daftar Program')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500">Program</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        <i class="fas fa-book-open mr-3"></i>
                        Manajemen Program Hafalan
                    </h1>
                    <p class="text-green-100 text-lg">
                        Kelola program hafalan Al-Qur'an untuk siswa
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.programs.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-green-600 font-semibold rounded-lg hover:bg-green-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Program
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('admin.programs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Program</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama program..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>
                    <!-- <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div> -->
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                        <select id="jenis" name="jenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            <option value="">Semua Jenis</option>
                            <option value="reguler" {{ request('jenis') === 'reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="intensif" {{ request('jenis') === 'intensif' ? 'selected' : '' }}>Intensif</option>
                            <option value="khusus" {{ request('jenis') === 'khusus' ? 'selected' : '' }}>Khusus</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.programs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mx-auto mb-4">
                    <i class="fas fa-book text-lg text-green-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Program</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mx-auto mb-4">
                    <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['active'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Program Aktif</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mx-auto mb-4">
                    <i class="fas fa-users text-lg text-blue-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_students'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Siswa</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-lg text-purple-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">{{ $stats['total_targets'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Target Juz</div>
            </div>
        </div>

        <!-- Programs Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h6 class="text-lg font-semibold text-gray-900">Daftar Program</h6>
            </div>
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-green-300 scrollbar-track-gray-100">
                <table class="min-w-full divide-y divide-gray-200" id="dataTable">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Program</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Guru</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Target</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-green-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($programs as $program)
                        <tr class="hover:bg-green-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $program->nama ?? 'Tidak ada nama' }}</div>
                                    <div class="text-sm text-gray-600">{{ ucfirst($program->jenis ?? 'reguler') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($program->guru)
                                    <div class="text-sm font-medium text-gray-900">{{ $program->guru->name }}</div>
                                @else
                                    <span class="text-sm text-gray-600">Belum ditentukan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900" title="{{ $program->deskripsi }}">
                                    {{ Str::limit($program->deskripsi ?? 'Tidak ada deskripsi', 30) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                    {{ $program->student_programs_count ?? 0 }} siswa
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900 mr-2">{{ $program->juz_targets_count ?? 0 }} Juz</span>
                                    <div class="w-16 bg-gray-200 rounded-full h-2">
                                        @php
                                            $percentage = ($program->juz_targets_count ?? 0) > 0 ? (($program->juz_targets_count ?? 0) / 30) * 100 : 0;
                                        @endphp
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($program->status === 'aktif')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $program->created_at ? $program->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="relative inline-block text-left">
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200" 
                                            onclick="toggleDropdown('dropdown-{{ $program->id }}')">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <div id="dropdown-{{ $program->id }}" 
                                         class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 border border-gray-200">
                                        <div class="py-1">
                                            <a href="{{ route('admin.programs.show', $program) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 transition-colors duration-200">
                                                <i class="fas fa-eye mr-3 text-green-600"></i>Detail
                                            </a>
                                            <a href="{{ route('admin.programs.edit', $program) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-green-50 transition-colors duration-200">
                                                <i class="fas fa-edit mr-3 text-green-600"></i>Edit
                                            </a>
                                            @if($program->deleted_at)
                                                <form action="{{ route('admin.programs.restore', $program) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-green-50 transition-colors duration-200"
                                                            onclick="return confirm('Yakin ingin memulihkan program ini?')">
                                                        <i class="fas fa-undo mr-3 text-green-600"></i>Pulihkan
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"
                                                            onclick="return confirm('Yakin ingin menghapus program ini?')">
                                                        <i class="fas fa-trash mr-3"></i>Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-book text-2xl text-green-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada program</h3>
                                    <p class="text-gray-600 mb-6">Mulai dengan membuat program hafalan pertama Anda.</p>
                                    <a href="{{ route('admin.programs.create') }}" 
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Program
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($programs->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($programs->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $programs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if($programs->hasMorePages())
                        <a href="{{ $programs->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-semibold">{{ $programs->firstItem() }}</span>
                            to
                            <span class="font-semibold">{{ $programs->lastItem() }}</span>
                            of
                            <span class="font-semibold">{{ $programs->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                            @if($programs->onFirstPage())
                                <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $programs->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-50 hover:border-green-300 transition-colors duration-200">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            @foreach($programs->getUrlRange(1, $programs->lastPage()) as $page => $url)
                                @if($page == $programs->currentPage())
                                    <span aria-current="page" class="z-10 bg-green-100 border-green-300 text-green-700 relative inline-flex items-center px-4 py-2 border text-sm font-semibold">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-700 hover:bg-green-50 hover:border-green-300 relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if($programs->hasMorePages())
                                <a href="{{ $programs->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-green-50 hover:border-green-300 transition-colors duration-200">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Dropdown toggle function
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(dd => {
        if (dd.id !== dropdownId) {
            dd.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    const allButtons = document.querySelectorAll('button[onclick*="toggleDropdown"]');
    
    let clickedButton = false;
    allButtons.forEach(button => {
        if (button.contains(event.target)) {
            clickedButton = true;
        }
    });
    
    if (!clickedButton) {
        allDropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

$(document).ready(function() {
    // Initialize progress bars
    $('.progress-bar').each(function() {
        var width = $(this).css('width');
        $(this).css('width', '0%').animate({
            width: width
        }, 1000);
    });

    // Initialize DataTable
    $('#dataTable').DataTable({
        "pageLength": 25,
        "responsive": true,
        "searching": false, // Disable built-in search since we have custom filters
        "paging": false, // Disable built-in pagination since we use Laravel pagination
        "info": false, // Disable info since we have custom info
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [7] } // Disable sorting on action column
        ]
    });

    // Delete program handler
    $(document).on('click', '.delete-program', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        
        confirmAction(
            'Hapus Program',
            'Apakah Anda yakin ingin menghapus program ini? Program yang dihapus masih dapat dipulihkan.',
            'warning'
        ).then((result) => {
            if (result.isConfirmed) {
                showLoading('Menghapus program...');
                
                // Create and submit form
                const form = $('<form>', {
                    method: 'POST',
                    action: url
                });
                
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: $('meta[name="csrf-token"]').attr('content')
                }));
                
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_method',
                    value: 'DELETE'
                }));
                
                $('body').append(form);
                form.submit();
            }
        });
    });

    // Restore program handler
    $(document).on('click', '.restore-program', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        
        confirmAction(
            'Pulihkan Program',
            'Apakah Anda yakin ingin memulihkan program ini?',
            'question'
        ).then((result) => {
            if (result.isConfirmed) {
                showLoading('Memulihkan program...');
                
                // Create and submit form
                const form = $('<form>', {
                    method: 'POST',
                    action: url
                });
                
                form.append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: $('meta[name="csrf-token"]').attr('content')
                }));
                
                $('body').append(form);
                form.submit();
            }
        });
    });
});
</script>
@endpush