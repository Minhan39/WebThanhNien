<!-- resources/views/delegates/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm thông tin đại biểu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('delegates.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên đại biểu</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="delegate_id" class="form-label">Mã đại biểu</label>
                            <input type="text" class="form-control" id="delegate_id" name="delegate_id" required>
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Đơn vị trực thuộc</label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                        </div> -->

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="is_guest" class="form-label">Khách mời</label>
                            <select class="form-control" id="is_guest" name="is_guest" required>
                                <option value="1">Có</option>
                                <option value="0">Không, đây là đại biểu</option>
                            </select>
                        </div> -->

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình thông tin đại biểu</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="card" class="form-label">Hình thẻ đại biểu</label>
                            <input type="file" class="form-control" id="card" name="card" accept="image/*" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
