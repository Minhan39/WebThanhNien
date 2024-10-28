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
          <!-- Nút thêm nhiều hình ảnh -->
          <button id="openModal" class="btn btn-secondary mb-3">Thêm nhiều hình ảnh</button>
          <form action="{{ route('photo.destroyAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá tất cả hình ảnh?')">Xoá Tất Cả</button>
          </form>

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

  <!-- Modal Thêm Nhiều Hình Ảnh -->
  <div id="uploadImagesModal" class="fixed inset-0 z-50 hidden justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full" style="margin: 32px auto;">
      <div class="flex justify-between items-center">
        <h5 class="text-lg font-semibold">Thêm Nhiều Hình Ảnh</h5>
        <button id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
      </div>
      <form action="{{ route('photo.storeMultiple') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
          <label for="images" class="block text-sm font-medium text-gray-700">Chọn hình ảnh (có thể chọn nhiều)</label>
          <input type="file" name="images[]" id="images" multiple required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
          @error('images')
          <span class="text-red-500 text-sm">{{ $message }}</span>
          @enderror
        </div>
        <div class="mt-6 flex justify-end">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-blue rounded hover:bg-blue-700">Tải lên</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('openModal').addEventListener('click', function() {
      document.getElementById('uploadImagesModal').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
      document.getElementById('uploadImagesModal').classList.add('hidden');
    });

    // Đóng modal khi nhấn ra ngoài
    window.onclick = function(event) {
      const modal = document.getElementById('uploadImagesModal');
      if (event.target === modal) {
        modal.classList.add('hidden');
      }
    };
  </script>
</x-app-layout>