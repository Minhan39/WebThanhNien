<!-- resources/views/images/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thêm hình ảnh') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('photo.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên hình ảnh:</label>
                            <input type="text" name="name" id="name" class="form-input w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Tệp hình ảnh:</label>
                            <input type="file" name="image" id="image" class="form-input w-full" accept="image/*" required>
                        </div>

                        <div class="mb-4">
                            <label for="alt" class="block text-gray-700 text-sm font-bold mb-2">Mô tả thay thế (Alt):</label>
                            <input type="text" name="alt" id="alt" class="form-input w-full" placeholder="Mô tả ngắn gọn về hình ảnh">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Mô tả chi tiết:</label>
                            <textarea name="description" id="description" rows="3" class="form-input w-full" placeholder="Mô tả chi tiết về hình ảnh"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="audio" class="block text-gray-700 text-sm font-bold mb-2">Tệp âm thanh:</label>
                            <input type="file" name="audio" accept="audio/*" class="form-input w-full">
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Thứ tự hiển thị:</label>
                            <input type="number" name="order" id="order" class="form-input w-full" min="0" value="0">
                        </div>

                        <div class="mb-4">
                            <label for="is_show" class="block text-gray-700 text-sm font-bold mb-2">Hiển thị:</label>
                            <select name="is_show" id="is_show" class="form-input w-full" required>
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Script to automatically set image name -->
    <script>
        document.getElementById('image').addEventListener('change', function() {
            const fileName = this.files[0].name;
            document.getElementById('name').value = fileName.split('.')[0]; // Set the name without the extension
        });
    </script>
</x-app-layout>