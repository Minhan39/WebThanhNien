<!-- resources/views/delegates/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Danh sách đại biểu') }}
        </h2>
        <a href="{{ route('delegates.add') }}" class="btn btn-info">Quét mã</a>
        <a target="_blank" rel="noopener noreferrer" href="{{ route('delegates.slide') }}" class="btn btn-warning">Màn chiếu</a>
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

                    <a href="{{ route('delegates.create') }}" class="btn btn-primary mb-3">Thêm đại biểu</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Tên</th>
                                <!-- <th>Mã đại biểu</th>
                                <th>Đơn vị trực thuộc</th> -->
                                <th>Số điện thoại</th>
                                <!-- <th>Khách mời</th> -->
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($delegates as $delegate)
                                <tr>
                                    <td>{{ $delegate->id }}</td>
                                    <td>{{ $delegate->name }}</td>
                                    <!-- <td>{{ $delegate->delegate_id }}</td>
                                    <td>{{ $delegate->unit }}</td> -->
                                    <td>{{ $delegate->phone }}</td>
                                    <!-- <td>{{ $delegate->is_guest ? 'Có' : 'Không, đây là đại biểu' }}</td> -->
                                    <td>
                                        <a href="{{ route('delegates.show', $delegate->id) }}" class="btn btn-info">Xem chi tiết</a>
                                        <a href="{{ route('delegates.edit', $delegate->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                                        <form action="{{ route('delegates.destroy', $delegate->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Xoá</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Chưa có đại biểu được thêm.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
