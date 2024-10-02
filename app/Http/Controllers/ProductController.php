<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
        $product->tags()->attach($tagIds);
        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category', 'tags')->find($id);
        return response()->json([
            'status' => true,   
            'message' => 'Product retrieved successfully',
            'data' => $product
        ]);
    }
    public function getTags(string $id)
    {
        $product = Product::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Tags retrieved successfully',
            'data' => $product->tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
        $product->tags()->sync($tagIds);
        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        $product->tags()->detach();
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
            'data' => $product
        ]);
    }
}
