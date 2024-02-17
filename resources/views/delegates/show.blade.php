<!-- resources/views/delegates/show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết thông tin đại biểu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-lg font-semibold">Thông tin đại biểu</h3>

                    <ul>
                        <li><strong>Tên:</strong> {{ $delegate->name }}</li>
                        <!-- <li><strong>Mã đại biểu:</strong> {{ $delegate->delegate_id }}</li>
                        <li><strong>Đơn vị trực thuộc:</strong> {{ $delegate->unit }}</li> -->
                        <li><strong>Số điện thoại:</strong> {{ $delegate->phone }}</li>
                        <!-- <li><strong>Khách mời:</strong> {{ $delegate->is_guest ? 'Có' : 'Không, đây là đại biểu' }}</li> -->
                        <li><strong>Hình thông tin đại biểu :</strong> <img src="{{ asset('storage/' . $delegate->image) }}" alt="Delegate Image" style="height: 160px; width: auto;"></li>
                        <li><strong>Hình thẻ đại biểu:</strong> <img src="{{ asset('storage/' . $delegate->card) }}" alt="Delegate Card" style="height: 160px; width: auto;"></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
