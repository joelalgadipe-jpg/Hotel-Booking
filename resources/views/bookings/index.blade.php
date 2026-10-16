<x-public-layout title="My Bookings | StayEase">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
        <p class="mt-1 text-gray-500">View and manage your reservations.</p>

        @if (session('success'))
            <div class="mt-6 p-3 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="mt-6 bg-white shadow-sm border border-gray-100 rounded-2xl overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Room</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Check-in</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Check-out</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Guests</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 font-medium text-gray-900">{{ $booking->room->name }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $booking->check_in->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $booking->check_out->format('M d, Y') }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $booking->guests }}</td>
                            <td class="px-5 py-4 font-medium text-gray-900">₱{{ number_format($booking->total_price, 2) }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $colors = [
                                        'pending'   => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if (in_array($booking->status, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}"
                                          onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-500">
                                You have no bookings yet.
                                <a href="{{ route('home') }}#rooms" class="text-indigo-600 font-medium hover:underline">Browse rooms</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-public-layout>