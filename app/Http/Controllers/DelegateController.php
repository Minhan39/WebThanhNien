<?php

namespace App\Http\Controllers;

use App\Models\Delegate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DelegateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delegates = Delegate::all();
        return view('delegates.index', compact('delegates'));
    }

    public function add(){
        return view('delegates.add');
    }

    public function slide(){
        return view('delegates.slide');
    }

    public function searchForm()
    {
        return view('delegates.search', ['status' => 'begin']);
    }

    public function find(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $delegate = Delegate::where('phone', $phone)->first();

        return response()->json(['delegate' => $delegate]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $phone = $request->input('phone');
        $delegate = Delegate::where('phone', $phone)->first();

        return view('delegates.search', ['delegate' => $delegate]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('delegates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'delegate_id' => 'nullable|string',
            'unit' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'card' => 'required|image|mimes:jpeg,png,jpg,gif',
            'phone' => 'required|string',
            'is_guest' => 'nullable|boolean',
        ]);

        $delegate = new Delegate();

        $delegate->name = $request->name;
        $delegate->delegate_id = $request->delegate_id;
        $delegate->unit = $request->unit;
        $delegate->phone = $request->phone;
        $delegate->is_guest = $request->is_guest;

        // Handle file uploads (image and pdf)
        $delegate->image = 'images/' . $request->file('image')->hashName();
        $delegate->card = 'images/' . $request->file('card')->hashName();

        // Store the files in the public disk
        $request->file('image')->storeAs('public', $delegate->image);
        $request->file('card')->storeAs('public', $delegate->card);

        $delegate->save();

        return redirect()->route('delegates')->with('success', 'Delegate created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Delegate $delegate)
    {
        return view('delegates.show', compact('delegate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delegate $delegate)
    {
        return view('delegates.edit', compact('delegate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delegate $delegate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'delegate_id' => 'nullable|string',
            'unit' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'card' => 'required|image|mimes:jpeg,png,jpg,gif',
            'phone' => 'required|string',
            'is_guest' => 'nullable|boolean',
        ]);

        $delegate->name = $request->name;
        $delegate->delegate_id = $request->delegate_id;
        $delegate->unit = $request->unit;
        $delegate->phone = $request->phone;
        $delegate->is_guest = $request->is_guest;

        // Update file uploads only if new files are provided
        if ($request->hasFile('image')) {
            Storage::delete('public/' . $delegate->image);
            $delegate->image = 'images/' . $request->file('image')->hashName();
            $request->file('image')->storeAs('public', $delegate->image);
        }

        if ($request->hasFile('card')) {
            Storage::delete('public/' . $delegate->card);
            $delegate->pdf = 'images/' . $request->file('card')->hashName();
            $request->file('card')->storeAs('public', $delegate->card);
        }

        $delegate->save();

        return redirect()->route('delegates')->with('success', 'Delegate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delegate $delegate)
    {
        $delegate->delete();

        Storage::delete(['public/' . $delegate->image, 'public/' . $delegate->card]);

        return redirect()->route('delegates')->with('success', 'Delegate deleted successfully');
    }
}
