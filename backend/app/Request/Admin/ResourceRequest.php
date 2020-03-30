<?php

declare(strict_types=1);

namespace App\Request\Admin;

use Hyperf\Validation\Rule;
use Hyperf\Validation\Request\FormRequest;

class ResourceRequest extends FormRequest
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
            'path' => [
                'required',
                'between:1,64',
                Rule::unique('resource')->where('action', $this->input('action')),
            ],
            'action' => [
                'required',
                Rule::in(['GET', 'POST', 'PATCH', 'DELETE'])
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'path' => '资源路径',
            'action' => '操作权限',
        ];
    }
}
