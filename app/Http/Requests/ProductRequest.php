<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'category_id' => 'required|exists:categories,id',

            'name' => 'required|string|max:255',

            'slug' => 'required|string|max:255',

            'sku' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric',

            'discount_price' => 'nullable|numeric',

            'stock_quantity' => 'required|integer',

            'status' => 'required|boolean',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ];
    }
}