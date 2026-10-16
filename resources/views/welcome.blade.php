<x-public-layout title="StayEase Hotel">

    {{-- HERO + SEARCH --}}
    <section class="text-white" style="background: linear-gradient(135deg, #4338ca 0%, #6d28d9 60%, #7c3aed 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <p class="inline-block px-3 py-1 text-xs font-semibold tracking-wide uppercase bg-white/20 rounded-full">
                Welcome to StayEase
            </p>
            <h1 class="mt-4 text-4xl sm:text-6xl font-bold leading-tight">
                Find your <br class="hidden sm:block">perfect stay
            </h1>
            <p class="mt-4 text-lg text-indigo-100 max-w-xl">
                Comfortable rooms, simple booking, and the best rates. Choose your dates and book in minutes.
            </p>

            <form method="GET" action="{{ route('home') }}#rooms"
                  class="mt-10 bg-white text-gray-800 rounded-2xl shadow-xl p-5 grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Check-in</label>
                    <input type="date" name="check_in" min="{{ date('Y-m-d') }}"
                           value="{{ request('check_in') }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Check-out</label>
                    <input type="date" name="check_out" min="{{ date('Y-m-d') }}"
                           value="{{ request('check_out') }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Guests</label>
                    <input type="number" name="guests" min="1" placeholder="1"
                           value="{{ request('guests') }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                    Search Rooms
                </button>
            </form>

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 text-red-800 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach ([
                ['Best Price', 'Honest rates with no hidden fees.'],
                ['Easy Booking', 'Reserve your room in just a few clicks.'],
                ['Comfort First', 'Clean, cozy, and well-kept rooms.'],
            ] as [$title, $text])
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="font-semibold text-gray-900">{{ $title }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ROOMS LIST --}}
    <section id="rooms" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Our Rooms</h2>
                <p class="mt-1 text-gray-500">Pick the room that fits your stay.</p>
            </div>

            @if (request()->hasAny(['check_in', 'check_out', 'guests']))
                <a href="{{ route('home') }}#rooms" class="text-sm font-medium text-indigo-600 hover:underline">
                    Clear search
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($rooms as $room)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition overflow-hidden flex flex-col border border-gray-100">
                    <div class="relative overflow-hidden">
                        @if ($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}"
                                 alt="{{ $room->name }}"
                                 class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-500">
                                No image
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 text-xs font-semibold px-3 py-1 bg-white/90 text-indigo-700 rounded-full">
                            {{ $room->type }}
                        </span>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $room->name }}</h3>

                        <p class="mt-2 text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit($room->description, 90) }}
                        </p>

                        <p class="mt-3 text-sm text-gray-500">Up to {{ $room->capacity }} guests</p>

                        <div class="mt-auto pt-5 flex items-center justify-between">
                            <p>
                                <span class="text-2xl font-bold text-indigo-600">
                                    ₱{{ number_format($room->price, 2) }}
                                </span>
                                <span class="text-sm text-gray-500">/ night</span>
                            </p>

                            <a href="{{ route('rooms.show', [
                                    'room'      => $room,
                                    'check_in'  => request('check_in'),
                                    'check_out' => request('check_out'),
                                    'guests'    => request('guests'),
                               ]) }}"
                               class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                View &amp; Book
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-16">
                    No rooms available. Try different dates or clear your search.
                </p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $rooms->links() }}
        </div>
    </section>

</x-public-layout>