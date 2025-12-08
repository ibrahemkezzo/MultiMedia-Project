<?php

namespace Modules\Auth\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return
            [
                'name'     => 'required|string|max:255',
                'email'    => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'roles'    => 'sometimes|array',
                'roles.*'  => 'exists:roles,name',
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
