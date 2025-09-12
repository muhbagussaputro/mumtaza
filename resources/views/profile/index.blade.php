@extends('layouts.app')

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold mb-4">Profile</h2>
                    <hr class="mb-4">
                    <p>{{ Auth::user()->name }}</p>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
