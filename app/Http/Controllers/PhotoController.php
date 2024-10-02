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

        return redirect()->route('photo')->with('success', 'Image uploaded successfully');
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
        Storage::delete('public/' . $photo->path);
        $photo->delete();

        return redirect()->route('photo')->with('success', 'Image deleted successfully');
    }
}