<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
   public function authorize(): bool
    {
        return Auth::user()->can('create-products');
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'exists:categories,id'],
            'store_id'          => ['required', 'exists:stores,id'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'price'             => ['required', 'numeric', 'min:0'],
            'compare_price'     => ['nullable', 'numeric', 'gte:price'],
            'sku'               => ['nullable', 'string', 'unique:products,sku'],
            'stock'             => ['required', 'integer', 'min:0'],
            'weight'            => ['nullable', 'numeric', 'min:0'],
            'dimensions'        => ['nullable', 'json'],
            'is_active'         => ['nullable', 'boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'images.*'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'images'            => ['array', 'max:10'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'              => 'اسم المنتج',
            'category_id'       => 'القسم',
            'short_description' => 'الوصف القصير',
            'description'       => 'الوصف',
            'price'             => 'السعر',
            'compare_price'     => 'سعر المقارنة',
            'sku'               => 'رمز المنتج',
            'stock'             => 'المخزون',
            'weight'            => 'الوزن',
            'dimensions'        => 'الأبعاد',
            'is_active'         => 'الحالة',
            'sort_order'        => 'ترتيب العرض',
            'images'            => 'الصور',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->has('is_active'),
            'sort_order' => $this->sort_order ?? 0,
        ]);
    }
}
