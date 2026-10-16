<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StayEase') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- LEFT: BRANDING --}}
        <div class="hidden lg:flex flex-col justify-between p-12 text-white"
             style="background: linear-gradient(135deg, #4338ca 0%, #6d28d9 60%, #7c3aed 100%);">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-2xl font-bold">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/20">S</span>
                StayEase
            </a>

            <div>
                <h2 class="text-4xl font-bold leading-tight">Your perfect stay is just a few clicks away.</h2>
                <p class="mt-4 text-indigo-100 text-lg max-w-md">
                    Create an account to book rooms, manage your reservations, and enjoy a smooth hotel experience.
                </p>

                <ul class="mt-8 space-y-3 text-indigo-50">
                    <li class="flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-white"></span> Easy online booking</li>
                    <li class="flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-white"></span> Real-time room availability</li>
                    <li class="flex items-center gap-3"><span class="w-2 h-2 rounded-full bg-white"></span> Manage or cancel anytime</li>
                </ul>
            </div>

            <p class="text-sm text-indigo-200">&copy; {{ date('Y') }} StayEase Hotel</p>
        </div>

        {{-- RIGHT: FORM --}}
        <div class="flex items-center justify-center p-6 sm:p-12 bg-gray-50">
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2 text-2xl font-bold text-indigo-600 mb-8">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-600 text-white text-base">S</span>
                    StayEase
                </a>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>