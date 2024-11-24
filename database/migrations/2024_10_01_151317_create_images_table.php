<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('path')->comment('Đường dẫn của hình ảnh');
            $table->string('name')->comment('Tên hình ảnh');
            $table->string('alt')->nullable()->comment('Mô tả thay thế cho hình ảnh');
            $table->text('description')->nullable()->comment('Mô tả chi tiết về hình ảnh');
            $table->boolean('is_show')->default(true)->comment('Trạng thái hiển thị');
            $table->integer('order')->default(0)->comment('Thứ tự sắp xếp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
