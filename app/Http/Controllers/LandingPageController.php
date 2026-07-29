<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Http\Requests\UpdateLandingPageRequest;
use App\Services\LandingPageService;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    public function __construct(
        private LandingPageService $landingService
    ) {}

    public function index()
    {
        $landingData = Cache::remember('landing_page_data', 3600, function () {
            $model = LandingPage::first();
            return $model ? $model->getAttributes() : null;
        });

        $landing = null;
        if ($landingData) {
            $landing = new LandingPage();
            $landing->setRawAttributes($landingData);
            $landing->exists = true;
            $landing->syncOriginal();
        }

        $features = \App\Models\Feature::orderBy('sort_order')->paginate(10);

        return view('admin.landingpage', compact('landing', 'features'));
    }

    public function panel($name)
    {
        $allowed = ['navigation', 'about', 'features', 'benefits', 'dashboard_tab', 'steps', 'testimonials', 'pricing', 'cta', 'footer'];
        if (!in_array($name, $allowed)) {
            abort(404);
        }

        $landingData = Cache::remember('landing_page_data', 3600, function () {
            $model = LandingPage::first();
            return $model ? $model->getAttributes() : null;
        });

        $landing = null;
        if ($landingData) {
            $landing = new LandingPage();
            $landing->setRawAttributes($landingData);
            $landing->exists = true;
            $landing->syncOriginal();
        }

        $data = compact('landing');
        if ($name === 'features') {
            $data['features'] = \App\Models\Feature::orderBy('sort_order')->paginate(10);
        }

        return view("admin.landing.panels.{$name}", $data);
    }

    public function update(UpdateLandingPageRequest $request)
    {
        $landing = LandingPage::first();

        $data = [
            'hero_title'            => $request->hero_title,
            'hero_description'      => $request->hero_description,
            'hero_badge'            => $request->hero_badge,
            'hero_cta_primary'      => $request->hero_cta_primary,
            'hero_cta_secondary'    => $request->hero_cta_secondary,
            'navbar_cta_text'       => $request->navbar_cta_text,
            'navbar_cta_url'        => $request->navbar_cta_url,
            'navbar_visible'        => $request->has('navbar_visible'),
            'about_title'           => $request->about_title,
            'about_description'     => $request->about_description,
            'dashboard_title'       => $request->dashboard_title,
            'dashboard_description' => $request->dashboard_description,
            'cta_title'             => $request->cta_title,
            'cta_description'       => $request->cta_description,
            'testimonials_visible'  => $request->has('testimonials_visible'),
            'about_visible'         => $request->has('about_visible'),
            'features_visible'      => $request->has('features_visible'),
            'benefits_visible'      => $request->has('benefits_visible'),
            'dashboard_visible'     => $request->has('dashboard_visible'),
            'steps_visible'         => $request->has('steps_visible'),
            'pricing_visible'       => $request->has('pricing_visible'),
            'cta_visible'           => $request->has('cta_visible'),
            'terms_gdrive_url'      => $request->terms_gdrive_url,
            'privacy_gdrive_url'    => $request->privacy_gdrive_url,
            'footer_description'    => $request->footer_description,
        ];

        $data = $this->landingService->handleImage($request, $landing, 'hero_image', $data);
        $data = $this->landingService->handleImage($request, $landing, 'about_image', $data);
        $data = $this->landingService->handleImage($request, $landing, 'dashboard_image', $data);
        $data = $this->landingService->processNavbarLinks($request, $data);
        $data = $this->landingService->processAboutPoints($request, $data);
        $data = $this->landingService->processBenefits($request, $data);
        $data = $this->landingService->processSteps($request, $data);
        $data = $this->landingService->processTestimonials($request, $data, $landing);
        $data = $this->landingService->processPricingPlans($request, $data);
        $data = $this->landingService->processSocialLinks($request, $data);

        if (!$landing) {
            LandingPage::create($data);
        } else {
            $landing->update($data);
        }

        Cache::forget('landing_page_data');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Landing Page berhasil diperbarui!',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Landing Page berhasil diperbarui!');
    }
}
