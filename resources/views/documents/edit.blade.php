<!-- resources/views/documents/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa văn kiện, nghị quyết') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên văn kiện, nghị quyết:</label>
                            <input type="text" name="name" id="name" class="form-input w-full" value="{{ $document->name }}" required>
                        </div>

                        <!-- <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả:</label>
                            <textarea name="description" id="description" class="form-input w-full" rows="4">{{ $document->description }}</textarea>
                        </div> -->

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Ảnh bìa:</label>
                            <img src="{{ asset('storage/' . $document->image) }}" alt="{{ $document->name }}" class="max-w-full mb-2" style="height: 160px; width: auto;" >
                            <input type="file" name="image" id="image" class="form-input w-full" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label for="pdf" class="block text-gray-700 text-sm font-bold mb-2">Tệp PDF:</label>
                            <a href="{{ asset('storage/' . $document->pdf) }}" target="_blank" class="text-decoration-none">Xem tệp nội dung PDF</a>
                            <input type="file" name="pdf" id="pdf" class="form-input w-full" accept=".pdf">
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
