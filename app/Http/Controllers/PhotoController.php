<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $images = Image::all();
    return view('photo.index', compact('images'));
  }

  public function indexApi(Request $request)
  {
    $from = $request->query('from', 0);
    $size = $request->query('size', 10);

    $total = Image::where('is_show', true)->count();
    $images = Image::where('is_show', true)
      ->skip($from)
      ->take($size)
      ->get();

    $pagination = [
      'total' => $total,
      'limit' => $size,
      'offset' => $from,
      'total_pages' => ceil($total / $size),
      'current_page' => floor($from / $size) + 1,
    ];

    return response()->json(['data' => $images, 'pagination' => $pagination]);
  }

  public function gallery()
  {
    $images = Image::where('is_show', true)
        ->orderBy('order', 'asc')
        ->get();
    return view('galleries.index', compact('images'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('photo.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
      'name' => 'required|string|max:255',
      'alt' => 'nullable|string|max:255',
      'description' => 'nullable|string|max:1000',
      'is_show' => 'required|boolean',
      'order' => 'nullable|integer|min:0',
    ]);

    $image = new Image();

    $image->name = $request->name;
    $image->alt = $request->alt;
    $image->description = $request->description;
    $image->is_show = $request->is_show;
    $image->order = $request->order ?? 0;

    // Handle image upload and convert to WebP
    $originalImage = \Intervention\Image\Facades\Image::make($request->file('image'));
    $filename = uniqid() . '.webp';
    $image->path = 'images/' . $filename;

    // Đảm bảo thư mục storage/app/public/images tồn tại và có quyền ghi
    $storagePath = storage_path('app/public/images');
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }
    
    // Sử dụng đường dẫn đầy đủ và đúng format
    $fullPath = $storagePath . DIRECTORY_SEPARATOR . $filename;
    $originalImage->encode('webp', 80)->save($fullPath);

    // Lưu âm thanh (nếu có)
    if ($request->hasFile('audio')) {
      $audio = $request->file('audio');
      $audioFilename = uniqid() . '.' . $audio->getClientOriginalExtension(); // Lấy phần mở rộng của file âm thanh
      $audioPath = 'audios/' . $audioFilename;
      
      // Lưu file âm thanh vào storage
      $audio->storeAs('public/' . dirname($audioPath), basename($audioPath));

      $image->audio_path = $audioPath;
    }

    $image->save();

    // Update image.json file
    $jsonPath = 'public/images/images.json';
    $currentData = Storage::exists($jsonPath) ? json_decode(Storage::get($jsonPath), true) : ['images' => []];

    // Add new image entry to the JSON structure
    $defaultLocation = json_decode($request->location);
    $currentData['images'][] = [
      'id' => pathinfo($image->path, PATHINFO_FILENAME),
      'title' => $image->name,
      'description' => $image->description,
      'position' => [
        'x' => $defaultLocation->x ?? 0,
        'y' =>  $defaultLocation->y ?? 0,
        'z' => $defaultLocation->z ?? 0,
      ],
      'rotation' => $defaultLocation->rotation ?? 0,
      'size' => [
        'width' => (int) $request->width,
        'height' => (int) $request->height,
      ],
      'audio' => $request->hasFile('audio') ? basename($audioPath) : null,
      'room' => $request->room,
    ];

    // Save the updated JSON back to the file
    Storage::put($jsonPath, json_encode($currentData, JSON_PRETTY_PRINT));

    return redirect()->route('photo')->with('success', 'Image uploaded successfully');
  }

  public function storeMultiple(Request $request)
{
    $request->validate([
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
        'audios.*' => 'nullable|mimes:mp3,wav,aac|max:10240',
    ]);

    // Lấy danh sách hình ảnh và âm thanh đã tải lên
    $uploadedImages = $request->file('images');
    $uploadedAudios = $request->file('audios', []);
    $jsonPath = 'public/images/images.json';
    $currentData = Storage::exists($jsonPath) ? json_decode(Storage::get($jsonPath), true) : ['images' => []];

    foreach ($uploadedImages as $index => $imageFile) {
        $image = new Image();

        // Gán các giá trị cho hình ảnh
        $image->name = $imageFile->getClientOriginalName();
        $image->is_show = true;

        // Xử lý tải lên và chuyển đổi sang WebP
        $originalImage = \Intervention\Image\Facades\Image::make($imageFile);
        $filename = uniqid() . '.webp';
        $image->path = 'images/' . $filename;

        // Lưu ảnh WebP với chất lượng 80%
        $originalImage->encode('webp', 80)
            ->save(storage_path('app/public/' . $image->path));

        $audioPath = null;
        if (isset($uploadedAudios[$index])) {
            $audioFile = $uploadedAudios[$index];
            $audioFilename = uniqid() . '.' . $audioFile->getClientOriginalExtension();
            $audioPath = 'audios/' . $audioFilename;
            $audioFile->storeAs('public/' . dirname($audioPath), basename($audioPath));
        }

        $image->audio_path = $audioPath; // Lưu đường dẫn âm thanh
        $image->save();

        // Thêm mục hình ảnh mới vào cấu trúc JSON
        $defaultLocation = json_decode($image->location);
        $currentData['images'][] = [
            'id' => basename($image->path),
            'title' => pathinfo($image->name, PATHINFO_FILENAME),
            'description' => $image->description,
            'position' => [
              'x' => $defaultLocation->x,
              'y' =>  $defaultLocation->y,
              'z' => $defaultLocation->z,
            ],
            'rotation' => $defaultLocation->rotation,
            'size' => [
              'width' => (int) $image->width,
              'height' => (int) $image->height,
            ],
            'audio' => $audioPath ? basename($audioPath) : null,
        ];
    }

    // Lưu dữ liệu JSON cập nhật lại vào file
    Storage::put($jsonPath, json_encode($currentData, JSON_PRETTY_PRINT));

    return redirect()->route('photo')->with('success', 'Images and audios uploaded successfully');
}

  /**
   * Display the specified resource.
   */
  public function show(Image $photo)
  {
    return view('photo.show', compact('photo'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Image $photo)
  {
    return view('photo.edit', compact('photo'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Image $photo)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'is_show' => 'required|boolean',
    ]);

    $photo->name = $request->name;
    $photo->is_show = $request->is_show;
    $photo->path = $request->path;

    // Update image only if a new file is provided
    // if ($request->hasFile('image')) {
    //     Storage::delete('public/' . $image->path);
    //     $image->path = 'images/' . $request->file('image')->hashName();
    //     $request->file('image')->storeAs('public', $image->path);
    // }

    $photo->save();

    return redirect()->route('photo')->with('success', 'Image updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Image $photo)
  {
    // Xóa file ảnh nếu tồn tại
    if (Storage::exists('public/' . $photo->path)) {
      Storage::delete('public/' . $photo->path);
    }

    // Xóa file âm thanh nếu tồn tại
    if ($photo->audio_path && Storage::exists('public/' . $photo->audio_path)) {
      Storage::delete('public/' . $photo->audio_path);
    }

    $photo->delete();

    // Path to the JSON file
    $jsonPath = 'public/images/images.json';

    // Check if the JSON file exists and read its contents
    if (Storage::exists($jsonPath)) {
      $currentData = json_decode(Storage::get($jsonPath), true);

      // Filter out the image entry based on title
      $currentData['images'] = array_filter($currentData['images'], function ($image) use ($photo) {
        return $image['title'] !== $photo->name;
      });

      // Re-index the array to maintain a continuous index
      $currentData['images'] = array_values($currentData['images']);

      // Save the updated JSON back to the file
      Storage::put($jsonPath, json_encode($currentData, JSON_PRETTY_PRINT));
    }

    return redirect()->route('photo')->with('success', 'Image deleted successfully');
  }

  public function destroyAll()
  {
    // Lấy tất cả hình ảnh
    $images = Image::all();

    // Xoá tất cả hình ảnh trong cơ sở dữ liệu
    foreach ($images as $photo) {
      $photo->delete();
    }

    // Path to the JSON file
    $jsonPath = 'public/images/images.json';

    // Kiểm tra xem tệp JSON có tồn tại không và đọc nội dung của nó
    if (Storage::exists($jsonPath)) {
      $currentData = json_decode(Storage::get($jsonPath), true);

      // Xoá tất cả hình ảnh trong mảng
      $currentData['images'] = [];

      // Lưu lại JSON đã cập nhật về tệp
      Storage::put($jsonPath, json_encode($currentData, JSON_PRETTY_PRINT));
    }

    return redirect()->route('photo')->with('success', 'All images deleted successfully');
  }
}
