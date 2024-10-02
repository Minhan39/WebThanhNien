<!-- resources/views/images/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết hình ảnh') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-lg font-semibold mb-4">{{ $photo->name }}</h3>

                    <div class="mb-4">
                        <strong>Hình ảnh:</strong><br>
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->name }}" class="max-w-full" style="height: 160px; width: auto;">
                    </div>

                    <div class="mb-4">
                        <strong>Hiển thị:</strong><br>
                        <span>{{ $photo->is_show ? 'Có' : 'Không' }}</span>
                    </div>

                    <a href="{{ route('photo.edit', $photo->id) }}" class="btn btn-warning">Chỉnh sửa</a>

                    <form action="{{ route('photo.destroy', $photo->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Xoá</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>