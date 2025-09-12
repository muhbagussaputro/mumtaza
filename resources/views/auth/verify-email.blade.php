<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Verify Email</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-teal-500 py-6 px-8">
                <img src="{{ asset('icon.png') }}" alt="Icon" class="w-16 h-16 mx-auto">
                <h2 class="text-2xl font-bold text-white text-center">Verify Your Email</h2>
                <p class="text-teal-100 text-center mt-1">We've sent a verification link to your email</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="mb-6 text-gray-600 text-sm">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-3 bg-green-50 text-green-700 text-sm rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 transform hover:scale-[1.01] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full mt-2 text-center text-sm text-teal-600 hover:text-teal-700 font-medium py-2 px-4 rounded-lg border border-teal-200 hover:bg-teal-50 transition duration-200">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 text-center">
                <p class="text-gray-600 text-sm">
                    Need help?
                    <a href="#" class="font-medium text-teal-600 hover:text-teal-700 ml-1">
                        {{ __('Contact Support') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
