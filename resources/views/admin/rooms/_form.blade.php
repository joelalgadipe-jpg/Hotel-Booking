@php
    $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500';
    $types = ['Standard', 'Deluxe', 'Suite', 'Family'];
@endphp

<div class="space-y-5">

    <div>
        <label class="block text-sm font-medium text-gray-700">Room Name</label>
        <input type="text" name="name" value="{{ old('name', $room->name ?? '') }}" class="{{ $inputClass }}">
        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Room Type</label>
        <select name="type" class="{{ $inputClass }}">
            @foreach ($types as $type)
                <option value="{{ $type }}" @selected(old('type', $room->type ?? '') === $type)>{{ $type }}</option>
            @endforeach
        </select>
        @error('type') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-gray-700">Price per night (₱)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $room->price ?? '') }}" class="{{ $inputClass }}">
            @error('price') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Capacity (number of guests)</label>
            <input type="number" name="capacity" value="{{ old('capacity', $room->capacity ?? '') }}" class="{{ $inputClass }}">
            @error('capacity') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="{{ $inputClass }}">
            <option value="available" @selected(old('status', $room->status ?? 'available') === 'available')>Available</option>
            <option value="unavailable" @selected(old('status', $room->status ?? '') === 'unavailable')>Unavailable</option>
        </select>
        @error('status') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" class="{{ $inputClass }}">{{ old('description', $room->description ?? '') }}</textarea>
        @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Room Image</label>

        @if (!empty($room?->image))
            <img src="{{ asset('storage/' . $room->image) }}" class="w-40 h-28 object-cover rounded-lg mt-2 mb-2" alt="Current image">
            <p class="text-xs text-gray-500 mb-1">Upload a new image to replace the current one.</p>
        @endif

        <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-700">
        @error('image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
            Save Room
        </button>
        <a href="{{ route('admin.rooms.index') }}" class="text-gray-600 hover:underline">Cancel</a>
    </div>
</div>