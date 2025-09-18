@extends('layouts.app')

@section('title', 'Progress Hafalan')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Progress Hafalan</h1>
                    <p class="text-gray-600 mt-1">Statistik dan progress hafalan {{ $student->name }}</p>
                </div>
            </div>
        </div>

        <!-- Overall Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-book text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Program</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_programs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Program Selesai</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed_programs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-clock text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Program Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['active_programs'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-chart-line text-teal-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Progress Keseluruhan</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['overall_progress'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        @if($programs->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-chart-line text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Program</h3>
                <p class="text-gray-500">Anda belum terdaftar dalam program hafalan apapun.</p>
            </div>
        @else
            <!-- Detailed Progress -->
            <div class="space-y-6">
                @foreach($programs as $studentProgram)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <!-- Program Header -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                        {{ $studentProgram->program->name }}
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        {{ $studentProgram->program->description }}
                                    </p>
                                    
                                    <!-- Overall Progress -->
                                    <div class="mb-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700">Progress Keseluruhan</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $studentProgram->progress }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-teal-600 h-3 rounded-full transition-all duration-500 progress-bar" 
                                                 data-progress="{{ $studentProgram->progress }}"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="ml-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $studentProgram->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($studentProgram->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Juz Progress Grid -->
                            @if(isset($studentProgram->juz_progress) && count($studentProgram->juz_progress) > 0)
                                <div class="mb-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Progress per Juz</h4>
                                    <div class="grid grid-cols-6 sm:grid-cols-10 lg:grid-cols-15 gap-2">
                                        @foreach($studentProgram->juz_progress as $juz)
                                            <div class="relative group">
                                                <div class="w-12 h-12 rounded-lg flex items-center justify-center text-sm font-medium transition-all duration-200
                                                    {{ $juz['completed'] ? 'bg-green-100 text-green-800 ring-2 ring-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                                    {{ $juz['juz_number'] }}
                                                </div>
                                                
                                                <!-- Tooltip -->
                                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap">
                                                    Juz {{ $juz['juz_number'] }} - {{ $juz['completed'] ? 'Selesai' : 'Belum Selesai' }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Progress Summary -->
                                    <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                                        <span>{{ $studentProgram->completed_juz }} dari {{ $studentProgram->total_juz }} Juz selesai</span>
                                        <span>{{ $studentProgram->total_juz - $studentProgram->completed_juz }} Juz tersisa</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Recent Entries -->
                            @if(isset($studentProgram->recent_entries) && $studentProgram->recent_entries->count() > 0)
                                <div class="border-t border-gray-200 pt-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Setoran Terbaru</h4>
                                    <div class="space-y-3">
                                        @foreach($studentProgram->recent_entries as $entry)
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                                                        <i class="fa-solid fa-book text-teal-600 text-xs"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">
                                                            {{ $entry->surah->name_latin ?? 'Surah tidak diketahui' }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $entry->created_at->format('d/m/Y H:i') }} - 
                                                            <span class="capitalize">{{ $entry->jenis_setoran }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($entry->klasifikasi === 'lancar') bg-green-100 text-green-800
                                                    @elseif($entry->klasifikasi === 'kurang_lancar') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ str_replace('_', ' ', ucfirst($entry->klasifikasi)) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('siswa.hafalan.detail', $studentProgram->program) }}" 
                                           class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                                            Lihat semua setoran →
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .progress-bar {
        width: 0%;
        transition: width 0.5s ease;
    }
    
    @media (min-width: 1024px) {
        .grid-cols-15 {
            grid-template-columns: repeat(15, minmax(0, 1fr));
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        setTimeout(function() {
            document.querySelectorAll('.progress-bar').forEach(function(bar) {
                const progress = bar.getAttribute('data-progress');
                bar.style.width = progress + '%';
            });
        }, 200);
        
        // Add smooth scroll to sections
        document.querySelectorAll('a[href^="#"]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    });
</script>
@endpush