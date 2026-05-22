<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['category', 'images']);

        if (request()->search) {
            $query->where('name', 'like', '%' . request()->search . '%');
        }

        if (request()->category) {
            $query->where('category_id', request()->category);
        }

        if (request()->min_price) {
            $query->where('price', '>=', request()->min_price);
        }

        if (request()->max_price) {
            $query->where('price', '<=', request()->max_price);
        }

        if (request()->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif (request()->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(10);

        return ApiResponse::success('Products List', ProductResource::collection($products));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        $product->load(['category', 'images']);

        return ApiResponse::success('Product Created Successfully', new ProductResource($product));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);

        return ApiResponse::success('Product Details', new ProductResource($product));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        $product->load(['category', 'images']);

        return ApiResponse::success('Product Updated Successfully', new ProductResource($product));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return ApiResponse::success('Product Deleted Successfully');
    }
}