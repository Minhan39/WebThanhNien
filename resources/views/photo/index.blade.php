<!-- resources/views/images/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách hình ảnh') }}
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

                    <a href="{{ route('photo.create') }}" class="btn btn-primary mb-3">Thêm hình ảnh</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tên hình ảnh</th>
                                <th>Hiển thị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($images as $image)
                                <tr>
                                    <td>{{ $image->id }}</td>
                                    <td>{{ $image->name }}</td>
                                    <td>{{ $image->is_show ? 'Có' : 'Không' }}</td>
                                    <td>
                                        <a href="{{ route('photo.show', $image->id) }}" class="btn btn-info">Xem chi tiết</a>
                                        <a href="{{ route('photo.edit', $image->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                                        <form action="{{ route('photo.destroy', $image->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá?')">Xoá</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Chưa có hình ảnh nào được thêm.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
