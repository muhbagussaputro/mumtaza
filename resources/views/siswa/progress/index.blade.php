@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white">
        <div class="px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('siswa.dashboard') }}" class="mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold">Progress Hafalan</h1>
                        <p class="text-teal-100 text-sm">Kemajuan hafalan per program</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Progress -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
            <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-24 h-24 mb-4">
                    <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-gray-200" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        <path class="text-teal-600" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" stroke-dasharray="{{ ($overall_progress ?? 0) }} 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-xl font-bold text-gray-900">{{ number_format($overall_progress ?? 0, 1) }}%</span>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Progress Keseluruhan</h3>
                <p class="text-sm text-gray-600">{{ $total_completed ?? 0 }} dari {{ $total_targets ?? 0 }} target selesai</p>
            </div>
        </div>
    </div>

    <!-- Programs Progress -->
    <div class="px-4">
        @if(isset($programs) && count($programs) > 0)
            <div class="space-y-4">
                @foreach($programs as $program)
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $program['nama'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $program['deskripsi'] ?? 'Program hafalan' }}</p>
                        </div>
                        <span class="text-lg font-bold text-teal-600">{{ number_format($program['progress'], 1) }}%</span>
                    </div>
                    
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                        <div class="bg-teal-600 h-3 rounded-full transition-all duration-500" data-width="{{ $program['progress'] }}"></div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-3 text-center text-sm">
                        <div>
                            <p class="font-medium text-gray-900">{{ $program['completed'] }}</p>
                            <p class="text-gray-600">Selesai</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $program['in_progress'] }}</p>
                            <p class="text-gray-600">Proses</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $program['remaining'] }}</p>
                            <p class="text-gray-600">Tersisa</p>
                        </div>
                    </div>
                    
                    @if(isset($program['juz_targets']) && count($program['juz_targets']) > 0)
                    <div class="mt-4">
                        <button class="text-teal-600 text-sm font-medium flex items-center" onclick="toggleDetails('program-{{ $program['id'] }}')">
                            <span>Lihat Detail</span>
                            <svg class="w-4 h-4 ml-1 transform transition-transform" id="icon-program-{{ $program['id'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div class="hidden mt-3" id="details-program-{{ $program['id'] }}">
                            <!-- Desktop Table View -->
                            <div class="hidden md:block">
                                <!-- Table Header -->
                                <div class="bg-green-50 rounded-t-lg p-3 border-b border-green-200">
                                    <div class="grid grid-cols-12 gap-2 text-xs font-semibold text-green-800 uppercase tracking-wide">
                                        <div class="col-span-4">Surah</div>
                                        <div class="col-span-3 text-center">Juz & Ayat</div>
                                        <div class="col-span-3 text-center">Status</div>
                                        <div class="col-span-2 text-center">Aksi</div>
                                    </div>
                                </div>
                                
                                <!-- Table Body -->
                                <div class="bg-white rounded-b-lg border border-t-0 border-green-200">
                                    @foreach($program['juz_targets'] as $index => $target)
                                    <div class="grid grid-cols-12 gap-2 p-3 items-center {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-green-50 transition-colors duration-200 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                        <!-- Surah Name -->
                                        <div class="col-span-4">
                                            <p class="font-medium text-gray-900 text-sm">{{ $target['surah_name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $target['surah_arabic'] ?? '' }}</p>
                                        </div>
                                        
                                        <!-- Juz & Ayat -->
                                        <div class="col-span-3 text-center">
                                            <div class="text-sm font-medium text-gray-900">Juz {{ $target['juz_ke'] }}</div>
                                            <div class="text-xs text-gray-600">Ayat {{ $target['ayat_mulai'] }}-{{ $target['ayat_selesai'] }}</div>
                                        </div>
                                        
                                        <!-- Status -->
                                        <div class="col-span-3 text-center">
                                            @if($target['status'] == 'completed')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @elseif($target['status'] == 'in_progress')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Proses
                                                </span>
                                            @elseif($target['status'] == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Belum
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Actions -->
                                        <div class="col-span-2 text-center">
                                            @if($target['status'] == 'completed')
                                                <button class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 transition-colors duration-200" title="Lihat Detail">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                </button>
                                            @elseif($target['status'] == 'in_progress')
                                                <button class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-200" title="Lanjutkan">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <button class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100 transition-colors duration-200" title="Mulai">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Mobile Card View -->
                            <div class="md:hidden space-y-3">
                                @foreach($program['juz_targets'] as $target)
                                <div class="bg-white border border-green-200 rounded-lg p-4 hover:bg-green-50 transition-colors duration-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 text-sm">{{ $target['surah_name'] }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">{{ $target['surah_arabic'] ?? '' }}</p>
                                        </div>
                                        <div class="ml-3">
                                            @if($target['status'] == 'completed')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @elseif($target['status'] == 'in_progress')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Proses
                                                </span>
                                            @elseif($target['status'] == 'pending')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Belum
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-600">
                                            <span class="font-medium">Juz {{ $target['juz_ke'] }}</span> • 
                                            <span>Ayat {{ $target['ayat_mulai'] }}-{{ $target['ayat_selesai'] }}</span>
                                        </div>
                                        <div>
                                            @if($target['status'] == 'completed')
                                                <button class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-md hover:bg-green-100 transition-colors duration-200" title="Lihat Detail">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Detail
                                                </button>
                                            @elseif($target['status'] == 'in_progress')
                                                <button class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-200" title="Lanjutkan">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    Lanjut
                                                </button>
                                            @else
                                                <button class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-50 border border-gray-200 rounded-md hover:bg-gray-100 transition-colors duration-200" title="Mulai">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    Mulai
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12a1 1 0 01-.117-1.993L9 10h6a1 1 0 01.117 1.993L15 12H9z"/>
                    <path fill-rule="evenodd" d="M4.172 3.172C3 4.343 3 6.229 3 10v4c0 3.771 0 5.657 1.172 6.828C5.343 22 7.229 22 11 22h2c3.771 0 5.657 0 6.828-1.172C21 19.657 21 17.771 21 14v-4c0-3.771 0-5.657-1.172-6.828C18.657 2 16.771 2 13 2h-2C7.229 2 5.343 2 4.172 3.172z" clip-rule="evenodd"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada program</h3>
                <p class="text-gray-500 text-sm">Anda belum terdaftar dalam program hafalan</p>
            </div>
        @endif
    </div>

    <!-- Achievement Section -->
    @if(isset($achievements) && count($achievements) > 0)
    <div class="px-4 py-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="font-semibold text-gray-900 mb-3">Pencapaian Terbaru</h3>
            <div class="space-y-3">
                @foreach($achievements as $achievement)
                <div class="flex items-center p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="font-medium text-gray-900">{{ $achievement['title'] }}</p>
                        <p class="text-sm text-gray-600">{{ $achievement['description'] }}</p>
                        <p class="text-xs text-gray-500">{{ $achievement['date'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="pb-6"></div>
</div>

<script>
function toggleDetails(programId) {
    const details = document.getElementById('details-' + programId);
    const icon = document.getElementById('icon-' + programId);
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        details.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}

// Initialize progress bars with animation
document.addEventListener('DOMContentLoaded', function() {
    const progressBars = document.querySelectorAll('[data-width]');
    progressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        setTimeout(() => {
            bar.style.width = width + '%';
        }, 100);
    });
});
</script>
@endsection