<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();
        return view('documents.index', compact('documents'));
    }

    public function file(){
        $documents = Document::orderByDesc('id')->take(15)->get();
        return view('documents.file', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'pdf' => 'required|mimes:pdf',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $document = new Document();

        $document->name = $request->name;
        $document->description = $request->description;

        // Handle file uploads (image and pdf)
        $document->image = 'images/' . $request->file('image')->hashName();
        $document->pdf = 'pdfs/' . $request->file('pdf')->hashName();

        // Store the files in the public disk
        $request->file('image')->storeAs('public', $document->image);
        $request->file('pdf')->storeAs('public', $document->pdf);

        $document->save();

        return redirect()->route('documents')->with('success', 'Văn kiện, nghị quyết được tạo thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        return view('documents.edit', compact('document'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $document->name = $request->name;
        $document->description = $request->description;

        // Update file uploads only if new files are provided
        if ($request->hasFile('image')) {
            Storage::delete('public/' . $document->image);
            $document->image = 'images/' . $request->file('image')->hashName();
            $request->file('image')->storeAs('public', $document->image);
        }

        if ($request->hasFile('pdf')) {
            Storage::delete('public/' . $document->pdf);
            $document->pdf = 'pdfs/' . $request->file('pdf')->hashName();
            $request->file('pdf')->storeAs('public', $document->pdf);
        }

        $document->save();

        return redirect()->route('documents')->with('success', 'Văn kiện, nghị quyết được cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $document->delete();

        Storage::delete(['public/' . $document->image, 'public/' . $document->pdf]);

        return redirect()->route('documents')->with('success', 'Xoá văn kiện, nghị quyết thành công');
    }
}
