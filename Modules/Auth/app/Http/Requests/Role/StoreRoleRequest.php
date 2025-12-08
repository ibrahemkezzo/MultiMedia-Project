<?php

namespace Modules\Auth\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
   public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:roles,name',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => __('This role name is already taken.'),
            'permissions.*.exists' => __('One or more selected permissions do not exist.'),
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
