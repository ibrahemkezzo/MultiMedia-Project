<?php

namespace Modules\Auth\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,name',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => __('validation.required', ['attribute' => 'الاسم']),
            'email.unique'      => __('this email is already taken'),
            'password.min'      => __('the password must be minmum 8 characters'),
            'roles.*.exists'    => __('One or more selected permissions do EFEdo not exist.'),
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
