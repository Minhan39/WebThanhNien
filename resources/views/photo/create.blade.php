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