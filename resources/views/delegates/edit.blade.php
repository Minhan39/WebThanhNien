<!-- resources/views/delegates/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa thông tin đại biểu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('delegates.update', $delegate->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên đại biểu</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $delegate->name) }}" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="delegate_id" class="form-label">Mã đại biểu</label>
                            <input type="text" class="form-control" id="delegate_id" name="delegate_id" value="{{ old('delegate_id', $delegate->delegate_id) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Đơn vị trực thuộc</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $delegate->unit) }}" required>
                        </div> -->

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $delegate->phone) }}" required>
                        </div>

                        <!-- <div class="mb-3">
                            <label for="is_guest" class="form-label">Khách mời</label>
                            <select class="form-control" id="is_guest" name="is_guest" required>
                                <option value="1" {{ old('is_guest', $delegate->is_guest) == 1 ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ old('is_guest', $delegate->is_guest) == 0 ? 'selected' : '' }}>Không, đây là đại biểu</option>
                            </select>
                        </div> -->

                        <div class="mb-3">
                            <label for="image" class="form-label">Hình thông tin đại biểu</label>
                            <img src="{{ asset('storage/' . $delegate->image) }}" alt="{{ $delegate->name }}" class="max-w-full mb-2" style="height: 160px; width: auto;">
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="card" class="form-label">Hình thẻ đại biểu</label>
                            <img src="{{ asset('storage/' . $delegate->card) }}" alt="{{ $delegate->name }}" class="max-w-full mb-2" style="height: 160px; width: auto;">
                            <input type="file" class="form-control" id="card" name="card" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật thông tin đại biểu</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
