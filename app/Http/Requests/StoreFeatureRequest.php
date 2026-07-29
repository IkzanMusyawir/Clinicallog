<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
            'icon_name'   => 'nullable|string|max:100',
            'sort_order'  => 'nullable|integer|min:1',
        ];
    }
}
