@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
        </div>

        <!-- Filter Program -->
        <div class="mb-6">
            <form method="GET" action="{{ route('guru.data-siswa') }}" class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="program_id" class="block text-sm font-medium text-gray-700 mb-2">Filter Program</label>
                    <select name="program_id" id="program_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ $programId == $program->id ? 'selected' : '' }}>
                                {{ $program->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Siswa -->
        @if($students->count() > 0)
            <div class="overflow-hidden">
                <x-responsive-datatable 
                    id="studentsTable" 
                    title="Data Siswa"
                    :headers="['No', 'Nama Siswa', 'Email', 'Program', 'Progress', 'Aksi']">
                
                <x-slot name="mobileCards">
                    @foreach($students as $index => $student)
                        @foreach($student->programs_with_progress as $programData)
                        <div class="mobile-card p-4 border-b border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $student->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                    @if($student->telepon)
                                        <p class="text-sm text-gray-500">{{ $student->telepon }}</p>
                                    @endif
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $programData['program']->nama }}
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm text-gray-600">Progress</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $programData['progress'] }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $programData['progress'] }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('guru.siswa.show', ['student' => $student->id, 'program_id' => $programData['program']->id]) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </x-slot>

                @foreach($students as $index => $student)
                    @foreach($student->programs_with_progress as $programData)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                @if($student->telepon)
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $student->telepon }}</div>
                                @endif
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">{{ $student->email }}</td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $programData['program']->nama }}
                                </span>
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 sm:w-20 bg-gray-200 rounded-full h-2.5 mr-2">
                                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $programData['progress'] }}%"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium text-gray-900 whitespace-nowrap">{{ $programData['progress'] }}%</span>
                                </div>
                            </td>
                            <td class="px-2 sm:px-4 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('guru.siswa.show', ['student' => $student->id, 'program_id' => $programData['program']->id]) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm" title="Lihat Detail Siswa">
                                    <span class="hidden sm:inline">Lihat Detail</span>
                                    <span class="sm:hidden">Detail</span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
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
<script>
    // Auto submit form when program selection changes
    document.getElementById('program_id').addEventListener('change', function() {
        this.form.submit();
    });
    
    // Initialize responsive datatable
    $(document).ready(function() {
        $('#studentsTable').addClass('responsive-datatable');
        
        window.ResponsiveDataTable.init('studentsTable', {
            "pageLength": 15,
            "order": [[1, "asc"]] // Sort by student name
        });
    });
</script>
@endpush