<?php

declare(strict_types=1);

namespace App\Request\Admin;

use App\Constants\State;
use Hyperf\Validation\Rule;
use Hyperf\Validation\Request\FormRequest;

class UserRequest extends FormRequest
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
            'username' => [
                'required',
                'between:4,24',
                Rule::unique('user')->ignore($this->input('id')),
            ],
            'password' => 'sometimes|required|between:6,32',
            'state' => Rule::in([State::ENABLED, State::DISABLED]),
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => '账号',
            'password' => '密码',
            'state'    => '状态',
        ];
    }
}
