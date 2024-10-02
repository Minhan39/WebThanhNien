<!-- resources/views/images/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa hình ảnh') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('photo.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên hình ảnh:</label>
                            <input type="text" name="name" id="name" class="form-input w-full" value="{{ $photo->name }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Hình ảnh:</label>
                            <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->name }}" class="max-w-full mb-2" style="height: 160px; width: auto;">
                            <input type="text" name="path" id="path" class="form-input w-full" value="{{ $photo->path }}" required hidden>
                            <!-- <input type="file" name="image" id="image" class="form-input w-full" accept="image/*"> -->
                        </div>

                        <div class="mb-4">
                            <label for="is_show" class="block text-gray-700 text-sm font-bold mb-2">Hiển thị:</label>
                            <select name="is_show" id="is_show" class="form-input w-full" required>
                                <option value="1" {{ $photo->is_show ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ !$photo->is_show ? 'selected' : '' }}>Không</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>