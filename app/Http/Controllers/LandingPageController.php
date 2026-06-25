<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $landing = LandingPage::first();
        $features = \App\Models\Feature::orderBy('sort_order')->paginate(10);

        return view('admin.landingpage', compact('landing', 'features'));
    }

    public function update(Request $request)
    {
        $request->validate([
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
        ]);

        $landing = LandingPage::first();

        $data = [
            'hero_title'            => $request->hero_title,
            'hero_description'      => $request->hero_description,
            'hero_badge'            => $request->hero_badge,
            'hero_cta_primary'      => $request->hero_cta_primary,
            'hero_cta_secondary'    => $request->hero_cta_secondary,
            'navbar_cta_text'       => $request->navbar_cta_text,
            'navbar_cta_url'        => $request->navbar_cta_url,
            'about_title'           => $request->about_title,
            'about_description'     => $request->about_description,
            'dashboard_title'       => $request->dashboard_title,
            'dashboard_description' => $request->dashboard_description,
            'cta_title'             => $request->cta_title,
            'cta_description'       => $request->cta_description,
            'testimonials_visible'  => $request->has('testimonials_visible') ? true : false,
            'about_visible'         => $request->has('about_visible') ? true : false,
            'features_visible'      => $request->has('features_visible') ? true : false,
            'benefits_visible'      => $request->has('benefits_visible') ? true : false,
            'dashboard_visible'     => $request->has('dashboard_visible') ? true : false,
            'steps_visible'         => $request->has('steps_visible') ? true : false,
            'pricing_visible'       => $request->has('pricing_visible') ? true : false,
            'cta_visible'           => $request->has('cta_visible') ? true : false,
            'terms_gdrive_url'      => $request->terms_gdrive_url,
            'privacy_gdrive_url'    => $request->privacy_gdrive_url,
        ];

        // Handle hero image upload/delete
        if ($request->hasFile('hero_image')) {
            if ($landing && $landing->hero_image) {
                Storage::disk('public')->delete($landing->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('landing', 'public');
        } elseif ($request->input('delete_hero_image') == 1) {
            if ($landing && $landing->hero_image) {
                Storage::disk('public')->delete($landing->hero_image);
            }
            $data['hero_image'] = null;
        }

        // Handle about image upload/delete
        if ($request->hasFile('about_image')) {
            if ($landing && $landing->about_image) {
                Storage::disk('public')->delete($landing->about_image);
            }
            $data['about_image'] = $request->file('about_image')->store('landing', 'public');
        } elseif ($request->input('delete_about_image') == 1) {
            if ($landing && $landing->about_image) {
                Storage::disk('public')->delete($landing->about_image);
            }
            $data['about_image'] = null;
        }

        // Handle dashboard image upload
        if ($request->hasFile('dashboard_image')) {
            if ($landing && $landing->dashboard_image) {
                Storage::disk('public')->delete($landing->dashboard_image);
            }
            $data['dashboard_image'] = $request->file('dashboard_image')->store('landing', 'public');
        } elseif ($request->input('delete_dashboard_image') == 1) {
            if ($landing && $landing->dashboard_image) {
                Storage::disk('public')->delete($landing->dashboard_image);
            }
            $data['dashboard_image'] = null;
        }

        // Process navbar links JSON
        if ($request->has('navbar_links')) {
            $links = [];
            $linkData = $request->input('navbar_links', []);
            if (is_array($linkData)) {
                foreach ($linkData as $l) {
                    if (!empty($l['label'])) {
                        $links[] = [
                            'label' => $l['label'],
                            'url'   => $l['url'] ?? '#',
                        ];
                    }
                }
            }
            $data['navbar_links'] = !empty($links) ? $links : null;
        }

        // Process benefits JSON
        if ($request->has('benefits')) {
            $benefits = [];
            $benefitData = $request->input('benefits', []);
            if (is_array($benefitData)) {
                foreach ($benefitData as $b) {
                    if (!empty($b['title'])) {
                        $benefits[] = [
                            'icon'  => $b['icon'] ?? 'zap',
                            'title' => $b['title'],
                        ];
                    }
                }
            }
            $data['benefits'] = !empty($benefits) ? $benefits : null;
        }

        // Process steps JSON
        if ($request->has('steps')) {
            $steps = [];
            $stepData = $request->input('steps', []);
            if (is_array($stepData)) {
                foreach ($stepData as $i => $s) {
                    if (!empty($s['title'])) {
                        $steps[] = [
                            'icon'  => $s['icon'] ?? 'clipboard-edit',
                            'num'   => str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                            'title' => $s['title'],
                            'desc'  => $s['desc'] ?? '',
                        ];
                    }
                }
            }
            $data['steps'] = !empty($steps) ? $steps : null;
        }

        // Process testimonials JSON
        if ($request->has('testimonials')) {
            $testimonials = [];
            $testiData = $request->input('testimonials', []);
            if (is_array($testiData)) {
                foreach ($testiData as $t) {
                    if (!empty($t['name'])) {
                        $testimonials[] = [
                            'quote' => $t['quote'] ?? '',
                            'name'  => $t['name'],
                            'role'  => $t['role'] ?? '',
                            'img'   => $t['img'] ?? '',
                        ];
                    }
                }
            }
            $data['testimonials'] = !empty($testimonials) ? $testimonials : null;
        }

        // Process pricing plans JSON
        if ($request->has('pricing_plans')) {
            $plans = [];
            $planData = $request->input('pricing_plans', []);
            if (is_array($planData)) {
                foreach ($planData as $p) {
                    // Save plan as long as name OR tier is filled
                    if (!empty($p['name']) || !empty($p['tier'])) {
                        $features = [];
                        if (!empty($p['features_text'])) {
                            $features = array_filter(array_map('trim', explode("\n", $p['features_text'])));
                            $features = array_values($features);
                        }
                        $plans[] = [
                            'tier'     => $p['tier'] ?? '',
                            'name'     => $p['name'] ?? '',
                            'price'    => $p['price'] ?? '',   // price is optional
                            'featured' => isset($p['featured']) && $p['featured'] ? true : false,
                            'features' => $features,
                        ];
                    }
                }
            }
            $data['pricing_plans'] = !empty($plans) ? $plans : null;
        }

        if (!$landing) {
            LandingPage::create($data);
        } else {
            $landing->update($data);
        }

        return redirect()
            ->back()
            ->with('success', 'Landing Page berhasil diperbarui!');
    }
}
