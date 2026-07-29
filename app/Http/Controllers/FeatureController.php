<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Services\FeatureService;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function __construct(
        private FeatureService $featureService
    ) {}

    public function index()
    {
        return redirect()->route('admin.landing.edit');
    }

    public function create()
    {
        return view('admin.features.form', [
            'totalFeatures' => Feature::count(),
        ]);
    }

    public function store(StoreFeatureRequest $request)
    {
        [$iconPath, $iconName] = $this->featureService->handleIconForNew($request);

        $totalFeatures = Feature::count();
        $newPosition = $this->featureService->getClampedPosition(
            $request->sort_order, $totalFeatures, true
        );

        $this->featureService->shiftForNewItem($newPosition);

        $feature = Feature::create([
            'title' => $request->title ?? '',
            'description' => $request->description ?? '',
            'icon' => $iconPath,
            'icon_name' => $iconName,
            'sort_order' => $newPosition,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Feature berhasil ditambahkan',
                'feature' => $feature,
            ]);
        }

        return redirect()->to(route('admin.landing.edit') . '#features')
            ->with('success', 'Feature berhasil ditambahkan');
    }

    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return view('admin.features.form', [
            'feature' => $feature,
            'totalFeatures' => Feature::count(),
        ]);
    }

    public function update(UpdateFeatureRequest $request, $id)
    {
        $feature = Feature::findOrFail($id);

        [$iconPath, $iconName] = $this->featureService->handleIcon($request, $feature);

        $totalFeatures = Feature::count();
        $newPosition = $this->featureService->getClampedPosition(
            $request->sort_order ?? $feature->sort_order, $totalFeatures
        );

        $this->featureService->reorder($feature->sort_order, $newPosition, $feature->id);

        $feature->update([
            'title' => $request->title ?? '',
            'description' => $request->description ?? '',
            'icon' => $iconPath,
            'icon_name' => $iconName,
            'sort_order' => $newPosition,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Feature berhasil diupdate',
            ]);
        }

        return redirect()->to(route('admin.landing.edit') . '#features')
            ->with('success', 'Feature berhasil diupdate');
    }

    public function destroy(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $deletedPosition = $feature->sort_order;

        if ($feature->icon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($feature->icon);
        }

        $feature->delete();
        $this->featureService->compactAfterDelete($deletedPosition);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Feature berhasil dihapus',
            ]);
        }

        return redirect()->to(route('admin.landing.edit') . '#features')
            ->with('success', 'Feature berhasil dihapus');
    }

    public function updateSortOrder(Request $request)
    {
        $ids = $request->input('ids', '');
        if (is_string($ids)) {
            $ids = array_filter(explode(',', $ids));
        }
        foreach ($ids as $index => $id) {
            Feature::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }
}
