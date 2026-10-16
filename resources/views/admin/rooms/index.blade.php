<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Rooms</h2>
            <a href="{{ route('admin.rooms.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                + Add Room
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm border border-gray-100 sm:rounded-2xl overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Image</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Capacity</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rooms as $room)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    @if ($room->image)
                                        <img src="{{ asset('storage/' . $room->image) }}"
                                             class="w-20 h-14 object-cover rounded-lg" alt="{{ $room->name }}">
                                    @else
                                        <div class="w-20 h-14 bg-gray-200 rounded-lg flex items-center justify-center text-xs text-gray-500">
                                            No image
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $room->name }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $room->type }}</td>
                                <td class="px-4 py-3 text-gray-700">₱{{ number_format($room->price, 2) }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $room->capacity }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('admin.rooms.edit', $room) }}"
                                           class="text-indigo-600 hover:underline text-sm font-medium">Edit</a>

                                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this room?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    No rooms yet. Click "+ Add Room" to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>