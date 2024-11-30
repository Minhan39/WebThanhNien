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
    <div class="bg-white rounded-lg p-6 max-w-xl w-full" style="margin: 32px auto;">
      <div class="flex justify-between items-center">
        <h5 class="text-lg font-semibold">Thêm Nhiều Hình Ảnh</h5>
        <button id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
      </div>
      <form id="uploadForm" action="{{ route('photo.storeMultiple') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mt-4">
          <label for="images" class="block text-sm font-medium text-gray-700">Chọn hình ảnh (có thể chọn nhiều)</label>
          <input type="file" name="images[]" id="images" multiple required 
                 class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                 accept="image/*">
          <div id="selectedFiles" class="mt-2 text-sm text-gray-600"></div>
          @error('images')
          <span class="text-red-500 text-sm">{{ $message }}</span>
          @enderror
        </div>
        <!-- Phần hiển thị hình ảnh đã chọn kèm input âm thanh -->
        <div id="selectedFiles" class="mt-4 space-y-4">
          <!-- JS sẽ thêm các phần tử tại đây -->
        </div>
        <div class="mt-6 flex justify-end">
          <button type="submit" class="px-4 py-2 bg-white text-black border border-black rounded hover:bg-black hover:text-white transition-colors duration-200">
            Tải lên
          </button>
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
    
    document.getElementById('images').addEventListener('change', function(event) {
      const files = event.target.files;
      const selectedFilesContainer = document.getElementById('selectedFiles');
      selectedFilesContainer.innerHTML = ''; // Xóa nội dung cũ

      Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
          // Tạo phần tử HTML để hiển thị hình ảnh và input âm thanh
          const fileWrapper = document.createElement('div');
          fileWrapper.classList.add('flex', 'items-center', 'space-x-6');

          // Hình ảnh xem trước
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = file.name;
          img.classList.add('w-32', 'h-32', 'rounded', 'border', 'border-gray-300', 'object-cover');

          // Nhãn cho input âm thanh
          const label = document.createElement('label');
          label.innerText = `Âm thanh cho: ${file.name}`;
          label.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');

          // Input âm thanh
          const audioInput = document.createElement('input');
          audioInput.type = 'file';
          audioInput.name = `audios[${index}]`;
          audioInput.accept = 'audio/*';
          audioInput.classList.add('mt-1', 'block', 'w-full', 'border-gray-300', 'rounded-md', 'shadow-sm', 'focus:ring', 'focus:ring-opacity-50');

          // Kết hợp label và input
          const inputWrapper = document.createElement('div');
          inputWrapper.appendChild(label);
          inputWrapper.appendChild(audioInput);

          // Gộp tất cả vào thẻ fileWrapper
          fileWrapper.appendChild(img);
          fileWrapper.appendChild(inputWrapper);
          selectedFilesContainer.appendChild(fileWrapper);
        };
        reader.readAsDataURL(file);
      });
    });
  </script>
</x-app-layout>