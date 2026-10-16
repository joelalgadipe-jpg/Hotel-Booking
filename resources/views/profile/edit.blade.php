<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Room</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.rooms.update', $room) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.rooms._form', ['room' => $room])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>