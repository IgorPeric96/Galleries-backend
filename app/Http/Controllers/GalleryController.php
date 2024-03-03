<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with(['images', 'user', 'comments'])->get();
        return response()->json($galleries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $gallery = Gallery::create($validated);

        return response()->json($gallery, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return response()->json($gallery->load(['images', 'comments', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        if($gallery->user_id !== auth()->id()) {
            return response()->json(['message' => 'Ne mozete mijenjati ovu Galeriju'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $gallery->update($validated);

        return response()->json($gallery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        if($gallery->user_id !== auth()->id()) {
            return response()->json(['message' => 'Ne mozete izbrisati ovu Galeriju'], 403);
        }

        $gallery->delete();
        return response()->json(['message' => 'Galerija je izbrisana']);
    }
}
