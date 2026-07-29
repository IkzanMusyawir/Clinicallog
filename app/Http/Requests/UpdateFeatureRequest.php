<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'icon'        => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
            'icon_name'   => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer|min:1',
            'delete_icon' => 'nullable|boolean',
        ];
    }
}
