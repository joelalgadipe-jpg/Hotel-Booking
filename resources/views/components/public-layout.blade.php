<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'StayEase Hotel' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    {{-- NAVBAR --}}
    <nav class="bg-white/90 backdrop-blur border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-indigo-600">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-600 text-white text-sm">S</span>
                StayEase
            </a>

            <div class="flex items-center gap-2 sm:gap-5 text-sm font-medium">
                <a href="{{ route('home') }}#rooms" class="text-gray-600 hover:text-indigo-600">Rooms</a>

                @auth
                    <a href="{{ route('bookings.index') }}" class="text-gray-600 hover:text-indigo-600">My Bookings</a>

                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.rooms.index') }}" class="text-gray-600 hover:text-indigo-600">Admin</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Log in</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="mt-20 bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div>
                <p class="text-lg font-bold text-white">StayEase</p>
                <p class="mt-2 text-sm text-gray-400">Comfortable rooms and easy booking, anytime.</p>
            </div>
            <div>
                <p class="font-semibold text-white">Quick Links</p>
                <ul class="mt-2 space-y-1 text-sm">
                    <li><a href="{{ route('home') }}#rooms" class="hover:text-white">Rooms</a></li>
                    <li><a href="{{ route('bookings.index') }}" class="hover:text-white">My Bookings</a></li>
                </ul>
            </div>
            <div>
                <p class="font-semibold text-white">Contact</p>
                <ul class="mt-2 space-y-1 text-sm text-gray-400">
                    <li>info@stayease.com</li>
                    <li>+63 900 000 0000</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 py-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} StayEase Hotel. All rights reserved.
        </div>
    </footer>

</body>
</html>