<?php

namespace App\Services;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageService
{
    public function handleImage(Request $request, ?LandingPage $landing, string $field, array $data): array
    {
        if ($request->hasFile($field)) {
            if ($landing && $landing->$field) {
                Storage::disk('public')->delete($landing->$field);
            }
            $data[$field] = $request->file($field)->store('landing', 'public');
        } elseif ($request->input('delete_' . $field) == 1) {
            if ($landing && $landing->$field) {
                Storage::disk('public')->delete($landing->$field);
            }
            $data[$field] = null;
        }
        return $data;
    }

    public function processNavbarLinks(Request $request, array $data): array
    {
        if (!$request->has('navbar_links')) return $data;

        $links = [];
        foreach ($request->input('navbar_links', []) as $l) {
            if (!empty($l['label'])) {
                $links[] = [
                    'label' => $l['label'],
                    'url'   => $l['url'] ?? '#',
                ];
            }
        }
        $data['navbar_links'] = !empty($links) ? $links : null;
        return $data;
    }

    public function processAboutPoints(Request $request, array $data): array
    {
        if (!$request->has('about_points')) return $data;

        $points = [];
        foreach ($request->input('about_points', []) as $p) {
            if (!empty($p['text'])) {
                $points[] = [
                    'text' => $p['text'],
                ];
            }
        }
        $data['about_points'] = !empty($points) ? $points : null;
        return $data;
    }

    public function processBenefits(Request $request, array $data): array
    {
        if (!$request->has('benefits')) return $data;

        $benefits = [];
        foreach ($request->input('benefits', []) as $b) {
            if (!empty($b['title'])) {
                $benefits[] = [
                    'icon'        => $b['icon'] ?? 'zap',
                    'title'       => $b['title'],
                    'description' => $b['description'] ?? '',
                    'stat'        => $b['stat'] ?? '',
                ];
            }
        }
        $data['benefits'] = !empty($benefits) ? $benefits : null;
        return $data;
    }

    public function processSteps(Request $request, array $data): array
    {
        if (!$request->has('steps')) return $data;

        $steps = [];
        foreach ($request->input('steps', []) as $i => $s) {
            if (!empty($s['title'])) {
                $steps[] = [
                    'icon'  => $s['icon'] ?? 'clipboard-edit',
                    'num'   => str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                    'title' => $s['title'],
                    'desc'  => $s['desc'] ?? '',
                ];
            }
        }
        $data['steps'] = !empty($steps) ? $steps : null;
        return $data;
    }

    public function processTestimonials(Request $request, array $data, ?LandingPage $landing): array
    {
        if (!$request->has('testimonials')) return $data;

        $testimonials = [];
        $testiData = $request->input('testimonials', []);
        if (is_array($testiData)) {
            foreach ($testiData as $index => $t) {
                $img = $t['img'] ?? '';

                $fileKey = "testimonials.{$index}.img_file";
                $hasNewFile = $request->hasFile($fileKey);

                if (!empty($t['delete_img'])) {
                    // Explicit delete requested — clear image first
                    if ($img && !str_starts_with($img, 'http')) {
                        Storage::disk('public')->delete($img);
                    }
                    $img = '';
                }

                if ($hasNewFile) {
                    // New file upload — delete old local file if any, then store new
                    if ($img && !str_starts_with($img, 'http')) {
                        Storage::disk('public')->delete($img);
                    }
                    $img = $request->file($fileKey)->store('testimonials', 'public');
                } elseif (!$hasNewFile && !empty($t['img_url'])) {
                    // Only apply URL if no file was uploaded
                    $img = $t['img_url'];
                }

                if (!empty($t['name'])) {
                    $testimonials[] = [
                        'quote' => $t['quote'] ?? '',
                        'name'  => $t['name'],
                        'role'  => $t['role'] ?? '',
                        'img'   => $img,
                    ];
                }
            }
        }
        $data['testimonials'] = !empty($testimonials) ? $testimonials : null;
        return $data;
    }

    public function processPricingPlans(Request $request, array $data): array
    {
        if (!$request->has('pricing_plans')) return $data;

        $plans = [];
        foreach ($request->input('pricing_plans', []) as $p) {
            if (!empty($p['name']) || !empty($p['tier'])) {
                $features = [];
                if (!empty($p['features_text'])) {
                    $features = array_values(array_filter(array_map('trim', explode("\n", $p['features_text']))));
                }
                $plans[] = [
                    'tier'     => $p['tier'] ?? '',
                    'name'     => $p['name'] ?? '',
                    'price'    => $p['price'] ?? '',
                    'featured' => !empty($p['featured']),
                    'features' => $features,
                ];
            }
        }
        $data['pricing_plans'] = !empty($plans) ? $plans : null;
        return $data;
    }

    public function processSocialLinks(Request $request, array $data): array
    {
        if (!$request->has('social_links')) return $data;

        $links = [];
        foreach ($request->input('social_links', []) as $s) {
            if (!empty($s['platform']) && !empty($s['url'])) {
                $links[] = [
                    'platform' => $s['platform'],
                    'url'      => $s['url'],
                ];
            }
        }
        $data['social_links'] = !empty($links) ? $links : null;
        return $data;
    }
}
