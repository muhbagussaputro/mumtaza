<a href="{{ route('dashboard') }}" class="flex items-center">
    @if(config('app.logo_url'))
        <img src="{{ config('app.logo_url') }}" alt="{{ config('app.name') }} Logo" class="h-8 w-auto">
    @else
        <img src="{{ asset('icon.png') }}" alt="Logo" class="h-8 w-auto">
    @endif
    <span class="font-bold ml-2 text-tosca-500 hover:text-tosca-600">{{ config('app.name') }}</span>
</a>
