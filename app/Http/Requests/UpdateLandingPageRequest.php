<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLandingPageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hero_title'            => 'nullable|string|max:500',
            'hero_description'      => 'nullable|string',
            'hero_image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'hero_badge'            => 'nullable|string|max:255',
            'hero_cta_primary'      => 'nullable|string|max:100',
            'hero_cta_secondary'    => 'nullable|string|max:100',
            'navbar_cta_text'       => 'nullable|string|max:100',
            'navbar_cta_url'        => 'nullable|string|max:255',
            'about_title'           => 'nullable|string|max:255',
            'about_description'     => 'nullable|string',
            'about_image'           => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'dashboard_title'       => 'nullable|string|max:255',
            'dashboard_description' => 'nullable|string',
            'dashboard_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'cta_title'             => 'nullable|string|max:500',
            'cta_description'       => 'nullable|string',
            'about_visible'         => 'nullable|boolean',
            'features_visible'      => 'nullable|boolean',
            'benefits_visible'      => 'nullable|boolean',
            'dashboard_visible'     => 'nullable|boolean',
            'steps_visible'         => 'nullable|boolean',
            'pricing_visible'       => 'nullable|boolean',
            'cta_visible'           => 'nullable|boolean',
            'terms_gdrive_url'      => 'nullable|string|max:2000',
            'privacy_gdrive_url'    => 'nullable|string|max:2000',
            'testimonials.*.img_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'about_points'          => 'nullable|array',
            'footer_description'    => 'nullable|string',
            'social_links'          => 'nullable|array',
        ];
    }
}
