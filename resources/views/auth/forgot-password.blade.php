<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Forgot Password</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }
        .password-toggle:hover {
            color: #0d9488;
        }
        .password-input-wrapper {
            position: relative;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-teal-500 py-6 px-8">
              <img src="{{ asset('icon.png') }}" alt="Icon" class="w-16 h-16 mx-auto">
                <h2 class="text-2xl font-bold text-white text-center">Reset Password</h2>
                <p class="text-teal-100 text-center mt-1">We'll email you a password reset link</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 px-8 pt-6" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="p-8">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        {{ __('Email') }}
                    </label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           value="{{ old('email') }}"
                           required 
                           autofocus 
                           autocomplete="email"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                           placeholder="Enter your email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                        {{ __('Back to login') }}
                    </a>
                    <button type="submit" 
                            class="bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 text-center">
                <p class="text-gray-600 text-sm">
                    Remember your password?
                    <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-700 ml-1">
                        {{ __('Sign in') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
