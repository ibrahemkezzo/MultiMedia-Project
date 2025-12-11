<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
{
public function authorize(): bool
    {
        return Auth::user()->can('edit-categories');
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'icon'        => ['nullable', 'string', 'max:100'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'is_active'   => ['nullable', 'boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'اسم القسم',
            'description' => 'الوصف',
            'image'       => 'الصورة',
            'icon'        => 'الأيقونة',
            'parent_id'   => 'القسم الأب',
            'is_active'   => 'الحالة',
            'sort_order'  => 'ترتيب العرض',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->has('is_active'),
            'sort_order' => $this->sort_order ?? $this->route('category')->sort_order,
        ]);
    }
}

/**
 * ===================================================================
 * شرح الكلاس: UpdateCategoryRequest
 * ===================================================================
 * الهدف: التحقق من البيانات عند تعديل قسم موجود
 * كيفية الاستخدام:
 *   في Controller: public function update(UpdateCategoryRequest $request, Category $category)
 * ===================================================================
 */
