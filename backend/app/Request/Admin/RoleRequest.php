<?php

declare(strict_types=1);

namespace App\Request\Admin;

use App\Constants\State;
use Hyperf\Validation\Rule;
use Hyperf\Validation\Request\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => [
                'required',
                'between:2,24',
                Rule::unique('role')->ignore($this->input('id')),
            ],
            'key' => [
                'required',
                'between:4,24',
                Rule::unique('role')->ignore($this->input('id')),
            ],
            'remark' => 'between:0,32',
            'state' => Rule::in([State::ENABLED, State::DISABLED]),
        ];
    }

    public function attributes(): array
    {
        return [
            'name'   => '名称',
            'key'    => '标识',
            'remark' => '备注',
            'state'  => '状态',
        ];
    }
}
