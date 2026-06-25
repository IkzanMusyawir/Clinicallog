<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_description',
        'hero_image',
        'hero_badge',
        'hero_cta_primary',
        'hero_cta_secondary',
        'navbar_links',
        'navbar_cta_text',
        'navbar_cta_url',
        'about_title',
        'about_description',
        'about_image',
        'about_visible',
        'features_visible',
        'dashboard_title',
        'dashboard_description',
        'dashboard_image',
        'dashboard_visible',
        'cta_title',
        'cta_description',
        'cta_visible',
        'benefits',
        'benefits_visible',
        'steps',
        'steps_visible',
        'testimonials',
        'testimonials_visible',
        'pricing_plans',
        'pricing_visible',
        'terms_gdrive_url',
        'privacy_gdrive_url',
    ];

    protected $casts = [
        'navbar_links'  => 'array',
        'benefits'      => 'array',
        'steps'         => 'array',
        'testimonials'  => 'array',
        'pricing_plans' => 'array',
        'testimonials_visible' => 'boolean',
        'about_visible' => 'boolean',
        'features_visible' => 'boolean',
        'benefits_visible' => 'boolean',
        'dashboard_visible' => 'boolean',
        'steps_visible' => 'boolean',
        'pricing_visible' => 'boolean',
        'cta_visible' => 'boolean',
    ];
}
