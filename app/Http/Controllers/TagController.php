<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return response()->json([
            'status' => true,
            'message' => 'Tags retrieved successfully',
            'data' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Tag created successfully',
            'data' => $tag
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Tag retrieved successfully',
            'data' => $tag
        ]);
    }
    public function getProducts(string $id)
    {
        $tag = Tag::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $tag->products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        $tag = Tag::find($id);
        $tag->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Tag updated successfully',
            'data' => $tag
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        $tag->delete();
        $tag->products()->detach();
        return response()->json([
            'status' => true,
            'message' => 'Tag deleted successfully',
            'data' => $tag
        ]);
    }
}
