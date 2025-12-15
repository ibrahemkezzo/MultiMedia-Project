<?php

namespace Modules\Store\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStoreRequest extends FormRequest
{
   public function authorize(): bool
    {
        return Auth::user()->can('edit-stores');
    }

  public function rules(): array
    {
        return [
            'user_id'     => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'address'     => ['nullable', 'string', 'max:255'],
            'city'        => ['nullable', 'string', 'max:100'],
            'country'     => ['nullable', 'string', 'max:100'],
            'phone'       => ['nullable', 'string', 'max:50'],
            'email'       => ['nullable', 'email', 'max:255'],
            'bio'         => ['nullable', 'string'],'balance'     => ['nullable', 'decimal:0,2'],
            'total_sales' => ['nullable', 'decimal:0,2'],
            'rating'      => ['nullable', 'integer', 'min:0', 'max:5'],
            'status'      => ['nullable', 'in:pending,active,suspended,rejected'],
            'logo_store'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'cover_store'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id'     => 'صاحب المتجر',
            'category_id' => 'التخصص',
            'name'        => 'اسم المتجر',
            'address'     => 'العنوان',
            'city'        => 'المدينة',
            'country'     => 'البلد',
            'phone'       => 'الهاتف',
            'email'       => 'البريد',
            'bio'         => 'الوصف',
            'balance'     => 'الرصيد',
            'total_sales' => 'إجمالي المبيعات',
            'rating'      => 'التقييم',
            'status'      => 'الحالة',
            'logo_store'  => 'لوغو',
            'cover_store'  => 'غلاف',
        ];
    }
}
