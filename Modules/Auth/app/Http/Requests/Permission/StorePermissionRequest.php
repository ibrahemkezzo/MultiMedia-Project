<?php

namespace Modules\Auth\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name|regex:/^[a-zA-Z0-9\-_\.]+$/',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('This permission already exists.'),
            'name.regex'  => __('Permission name may only contain letters, numbers, dashes, underscores, and dots.'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
