<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    { //Display a listing of the resource.
        $categories = Category::with(['parent', 'children'])
            ->latest()
            ->paginate(10);

        return ApiResponse::success('Categories List', CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request)
    { //Store a newly created resource in storage.

        $category = Category::create($request->validated());

        return ApiResponse::success('Category Created Successfully', new CategoryResource($category));
    }

    public function show(Category $category)
    { // Display the specified resource
        $category->load(['parent', 'children']);

        return ApiResponse::success('Category Details', new CategoryResource($category));
    }

    public function update(CategoryRequest $request, Category $category)
    {  //Update the specified resource in storage.

        $category->update($request->validated());

        return ApiResponse::success('Category Updated Successfully', new CategoryResource($category));
    }

    public function destroy(Category $category)
    {//Remove the specified resource from storage.
        $category->delete();

        return ApiResponse::success('Category Deleted Successfully');
    }
}