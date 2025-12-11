<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->can('create-categories');
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'icon'        => ['nullable', 'string', 'max:100'], // e.g., "fa fa-mobile"
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
            'sort_order' => $this->sort_order ?? 0,
        ]);
    }
}

/**
 * ===================================================================
 * شرح الكلاس: StoreCategoryRequest
 * ===================================================================
 * الهدف: التحقق من البيانات عند إنشاء قسم جديد
 * لماذا وُجود: لفصل الـ validation عن الـ Controller
 * كيفية الاستخدام:
 *   في Controller: public function store(StoreCategoryRequest $request)
 * ===================================================================
 */
