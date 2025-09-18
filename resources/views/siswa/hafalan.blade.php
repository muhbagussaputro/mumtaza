@extends('layouts.app')

@section('title', 'Hafalan Saya')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Hafalan Saya</h1>
                    <p class="text-gray-600 mt-1">Progress hafalan {{ $student->name }}</p>
                </div>
            </div>
        </div>

        @if($programs->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-book text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Program</h3>
                <p class="text-gray-500">Anda belum terdaftar dalam program hafalan apapun.</p>
            </div>
        @else
            <!-- Programs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programs as $studentProgram)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <!-- Program Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ $studentProgram->program->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $studentProgram->program->description }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $studentProgram->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($studentProgram->status) }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progress</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $studentProgram->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-teal-600 h-2 rounded-full transition-all duration-300 progress-bar" 
                                         data-progress="{{ $studentProgram->progress }}"></div>
                                </div>
                            </div>

                            <!-- Juz Progress -->
                            @if(isset($studentProgram->juz_progress) && count($studentProgram->juz_progress) > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Progress Juz</h4>
                                    <div class="grid grid-cols-6 gap-1">
                                        @foreach($studentProgram->juz_progress as $juz)
                                            <div class="w-8 h-8 rounded flex items-center justify-center text-xs font-medium
                                                {{ $juz['completed'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                {{ $juz['juz_number'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Action Button -->
                            <div class="pt-4 border-t border-gray-100">
                                <a href="{{ route('siswa.hafalan.detail', $studentProgram->program) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 transition-colors">
                                    <i class="fa-solid fa-eye mr-2"></i>
                                    Lihat Detail
                                </a>
                            </div>
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
        transition: width 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set progress bar widths
        document.querySelectorAll('.progress-bar').forEach(function(bar) {
            const progress = bar.getAttribute('data-progress');
            setTimeout(function() {
                bar.style.width = progress + '%';
            }, 100);
        });
    });
</script>
@endpush