<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class PasswordRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'old_password' => 'required|between:6,32',
            'new_password' => 'required|between:6,32|confirmed',
            'new_password_confirmation' => 'required|between:6,32',
        ];
    }

    public function attributes(): array
    {
        return [
            'old_password' => '旧密码',
            'new_password' => '新密码',
            'new_password_confirmation' => '重复新密码',
        ];
    }
}
