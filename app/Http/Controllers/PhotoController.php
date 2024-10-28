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
    $images = Image::where('is_show', true)->get();
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
      'name' => 'required|string|max:255',
      'is_show' => 'required|boolean',
    ]);

    $image = new Image();

    $image->name = $request->name;
    $image->is_show = $request->is_show;

    // Handle image upload
    $image->path = 'images/' . $request->file('image')->hashName();
    $request->file('image')->storeAs('public', $image->path);

    $image->save();

    // Update image.json file
    $jsonPath = 'public/images/images.json';
    $currentData = Storage::exists($jsonPath) ? json_decode(Storage::get($jsonPath), true) : ['images' => []];

    // Add new image entry to the JSON structure
    $currentData['images'][] = [
      'title' => $image->name,
      'file' => basename($image->path),
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
    ]);

    // Lấy danh sách hình ảnh đã tải lên
    $uploadedImages = $request->file('images');
    $jsonPath = 'public/images/images.json';
    $currentData = Storage::exists($jsonPath) ? json_decode(Storage::get($jsonPath), true) : ['images' => []];

    foreach ($uploadedImages as $imageFile) {
      $image = new Image();

      // Gán các giá trị cho hình ảnh
      $image->name = $imageFile->getClientOriginalName(); // Tên file gốc
      $image->is_show = true; // Đặt is_show là true

      // Xử lý tải lên hình ảnh
      $image->path = 'images/' . $imageFile->hashName();
      $imageFile->storeAs('public', $image->path);

      $image->save();

      // Thêm mục hình ảnh mới vào cấu trúc JSON
      $currentData['images'][] = [
        'title' => $image->name,
        'file' => basename($image->path),
      ];
    }

    // Lưu dữ liệu JSON cập nhật lại vào file
    Storage::put($jsonPath, json_encode($currentData, JSON_PRETTY_PRINT));

    return redirect()->route('photo')->with('success', 'Images uploaded successfully');
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
