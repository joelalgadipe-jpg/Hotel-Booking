<x-public-layout :title="$room->name . ' | StayEase'">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <a href="{{ route('home') }}#rooms" class="text-sm font-medium text-indigo-600 hover:underline">
            &larr; Back to rooms
        </a>

        <div class="mt-5 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ROOM INFO --}}
            <div class="lg:col-span-2">
                @if ($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}"
                         alt="{{ $room->name }}" class="w-full h-96 object-cover rounded-2xl shadow-sm">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-2xl flex items-center justify-center text-gray-500">
                        No image
                    </div>
                @endif

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $room->name }}</h1>
                    <span class="text-xs font-semibold px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full">
                        {{ $room->type }}
                    </span>
                </div>

                <p class="mt-2 text-gray-500">Up to {{ $room->capacity }} guests</p>

                <h2 class="mt-8 text-lg font-semibold text-gray-900">About this room</h2>
                <p class="mt-2 text-gray-700 leading-relaxed">
                    {{ $room->description ?: 'No description available.' }}
                </p>
            </div>

            {{-- BOOKING CARD --}}
            <div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 lg:sticky lg:top-24">
                    <p>
                        <span class="text-3xl font-bold text-indigo-600">₱{{ number_format($room->price, 2) }}</span>
                        <span class="text-gray-500">/ night</span>
                    </p>

                    @if (session('error'))
                        <div class="mt-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if ($room->status !== 'available')

                        <p class="mt-4 text-red-600 font-medium">This room is currently unavailable.</p>

                    @elseif (auth()->check())

                        <form method="POST" action="{{ route('bookings.store') }}" class="mt-5 space-y-4">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Check-in</label>
                                <input type="date" id="check_in" name="check_in" min="{{ date('Y-m-d') }}"
                                       value="{{ old('check_in', request('check_in')) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Check-out</label>
                                <input type="date" id="check_out" name="check_out" min="{{ date('Y-m-d') }}"
                                       value="{{ old('check_out', request('check_out')) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Guests</label>
                                <input type="number" name="guests" min="1" max="{{ $room->capacity }}"
                                       value="{{ old('guests', request('guests', 1)) }}"
                                       class="mt-1 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            <div class="border-t pt-4 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Nights</span>
                                    <span id="nights">-</span>
                                </div>
                                <div class="flex justify-between mt-2 text-base font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span id="total">-</span>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                                Book Now
                            </button>
                        </form>

                        <script>
                            const pricePerNight = {{ $room->price }};
                            const checkInInput  = document.getElementById('check_in');
                            const checkOutInput = document.getElementById('check_out');
                            const nightsText    = document.getElementById('nights');
                            const totalText     = document.getElementById('total');

                            function updateTotal() {
                                const start = new Date(checkInInput.value);
                                const end   = new Date(checkOutInput.value);
                                const nights = Math.round((end - start) / (1000 * 60 * 60 * 24));

                                if (nights > 0) {
                                    nightsText.textContent = nights;
                                    totalText.textContent = '₱' + (nights * pricePerNight).toLocaleString('en-PH', {
                                        minimumFractionDigits: 2
                                    });
                                } else {
                                    nightsText.textContent = '-';
                                    totalText.textContent = '-';
                                }
                            }

                            checkInInput.addEventListener('change', updateTotal);
                            checkOutInput.addEventListener('change', updateTotal);
                            updateTotal();
                        </script>

                    @else

                        <p class="mt-5 text-sm text-gray-600">Please log in to book this room.</p>
                        <a href="{{ route('login') }}"
                           class="mt-3 block text-center py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                            Log in to book
                        </a>
                        <p class="mt-3 text-center text-sm text-gray-500">
                            No account yet?
                            <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Register</a>
                        </p>

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-public-layout>