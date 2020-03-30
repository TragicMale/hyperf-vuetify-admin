<?php

declare(strict_types=1);

namespace App\Request\Admin;

use App\Constants\MenuType;
use App\Constants\State;
use Hyperf\Validation\Rule;
use Hyperf\Validation\Request\FormRequest;

class MenuRequest extends FormRequest
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
            'pid' => 'integer',
            'type' => [
                'required',
                Rule::in([MenuType::MENU, MenuType::BUTTON]),
            ],
            'name' => [
                'required',
                'between:2,24',
                Rule::unique('menu')->where('type', 1)->ignore($this->input('id')),
            ],
            'icon' => 'between:0,16',
            'path' => 'between:1,32',
            'state' => Rule::in([State::ENABLED, State::DISABLED]),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '名称',
            'icon' => '图标',
            'path' => '前端路由',
            'state' => '状态',
        ];
    }
}
