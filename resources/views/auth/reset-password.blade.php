<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Reset Password</title>
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
                <p class="text-teal-100 text-center mt-1">Create your new password</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}" class="p-8">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        {{ __('Email') }}
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}"
                        required autofocus autocomplete="username"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="Enter your email">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                        {{ __('Password') }}
                    </label>
                    <div class="password-input-wrapper">
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 pr-10"
                            placeholder="••••••••">
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="far fa-eye" id="toggleIconPassword"></i>
                        </span>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">
                        {{ __('Confirm Password') }}
                    </label>
                    <div class="password-input-wrapper">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 pr-10"
                            placeholder="••••••••">
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="far fa-eye" id="toggleIconConfirmPassword"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        {{ __('Reset Password') }}
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

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(`toggleIcon${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
