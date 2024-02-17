<!-- resources/views/documents/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết văn kiện, nghị quyết') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-lg font-semibold mb-4">{{ $document->name }}</h3>

                    <!-- @if($document->description)
                        <p class="text-gray-700 mb-4">{{ $document->description }}</p>
                    @endif -->

                    <div class="mb-4">
                        <strong>Bìa:</strong><br>
                        <img src="{{ asset('storage/' . $document->image) }}" alt="{{ $document->name }}" class="max-w-full" style="height: 160px; width: auto;">
                    </div>

                    <div class="mb-4">
                        <strong>PDF:</strong><br>
                        <a href="{{ asset('storage/' . $document->pdf) }}" target="_blank" class="text-decoration-none">Xem tệp nội dung PDF</a>
                    </div>

                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">Chỉnh sửa</a>

                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Xoá</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
