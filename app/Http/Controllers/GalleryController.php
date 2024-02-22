<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('galleries.index', compact('galleries'));
    }

    public function tan_dinh()
    {
        return view('galleries.tan_dinh');
    }
    public function an_dien()
    {
        return view('galleries.an_dien');
    }
    public function chanh_phu_hoa()
    {
        return view('galleries.chanh_phu_hoa');
    }
    public function hoa_loi()
    {
        return view('galleries.hoa_loi');
    }
    public function my_phuoc()
    {
        return view('galleries.my_phuoc');
    }
    public function phu_an()
    {
        return view('galleries.phu_an');
    }
    public function an_tay()
    {
        return view('galleries.an_tay');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $gallery = new Gallery;
                $gallery->image = 'images/' . $image->hashName();
                $image->storeAs('public', $gallery->image);
                $gallery->location = $request->location;
                $gallery->save();
            }
        } else {
            return redirect()->route('galleries.create')->with('error', 'Please upload an image');
        }

        return redirect()->route('galleries.index')->with('success', 'Gallery created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('galleries.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        if ($request->hasFile('image')) {
            $gallery->image = 'images/' . $request->file('image')->hashName();
            $request->file('image')->storeAs('public', $gallery->image);
        }

        $gallery->location = $request->location;
        $gallery->save();

        return redirect()->route('galleries.index')->with('success', 'Gallery updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        Storage::delete(['public/' . $gallery->image]);

        return redirect()->route('galleries.index')->with('success', 'Gallery deleted successfully');
    }
}
