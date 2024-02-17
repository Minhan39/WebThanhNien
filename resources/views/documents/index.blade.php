<!-- resources/views/documents/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách văn kiện, nghị quyết') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3">Thêm văn kiện, nghị quyết</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tên văn kiện</th>
                                <!-- <th>Mô tả</th> -->
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                                <tr>
                                    <td>{{ $document->id }}</td>
                                    <td>{{ $document->name }}</td>
                                    <!-- <td>{{ $document->description }}</td> -->
                                    <td>
                                        <a href="{{ route('documents.show', $document->id) }}" class="btn btn-info">Xem chi tiết</a>
                                        <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Xoá</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Chưa có văn kiện, nghị quyết được thêm.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
