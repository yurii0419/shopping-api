<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Measurement;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductListingPageController extends Controller
{
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'sub_subcategory_id' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = strtolower(str_replace(' ', '-', $request->product_name));
        $tags = explode(', ', $request->tags ?? '');

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'sub_subcategory_id' => $validated['sub_subcategory_id'],
            'user_id' => Auth::id(),
            'product_name' => $validated['product_name'],
            'product_description' => $validated['product_description'],
            'price' => $validated['price'],
            'slug' => $slug,
            'keyword' => $tags,

        ]);
        if ($request->filled(['chest', 'shoulders', 'sleeve_length', 'length', 'hem'])) {
            Measurement::create([
                'product_id' => $product->id,
                'chest' => $request->chest,
                'shoulders' => $request->shoulders,
                'sleeve_length' => $request->sleeve_length,
                'length' => $request->length,
                'hem' => $request->hem,
            ]);
        }


        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = 'product_' . $product->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('productimages/' . $product->user_id, $filename, 'public');

                Image::create([
                    'product_id' => $product->id,
                    'filename' => $filename,
                    'path' => Storage::url($path),
                ]);
            }
        }

        return response()->json([
            'message' => 'Product added successfully',
            'product' => $product->load(['images', 'measurements']), // Assuming you have these relationships
        ], 201);
    }
    public function editProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);


        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'sub_subcategory_id' => 'required|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $product->update($validated);



        return response()->json(['message' => 'Product updated successfully!', 'product' => $product]);
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);


        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }

    public function listProducts()
    {
        $products = Product::with('user')
            ->orderBy('user_id')
            ->get();

        return response()->json($products);
    }
    public function addMeasurements(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);


        $validatedData = $request->validate([
            'chest' => 'required|numeric',
            'shoulders' => 'required|numeric',
            'sleeve_length' => 'required|numeric',
            'length' => 'required|numeric',
            'hem' => 'required|numeric',
            'measurement_unit' => 'required|string',
        ]);


        $measurement = $product->measurements()->updateOrCreate(
            ['product_id' => $productId],
            $validatedData
        );

        return response()->json(['message' => 'Measurements added/updated successfully!', 'measurements' => $measurement]);
    }

    public function addShippingDetails(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);


        $validatedData = $request->validate([
            'weight' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'depth' => 'required|numeric',
            'shipping_fee' => 'required|numeric',
            'shipping_type' => 'required|string',
            //this is initial validation
        ]);


        $shippingDetails = $product->shipping()->updateOrCreate(
            ['product_id' => $productId],
            $validatedData
        );

        return response()->json(['message' => 'Shipping details added/updated successfully!', 'shippingDetails' => $shippingDetails]);
    }
}