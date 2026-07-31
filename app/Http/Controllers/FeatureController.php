<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Services\FeatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeatureController extends Controller
{
    public function __construct(
        private FeatureService $featureService
    ) {}

    public function index()
    {
        return redirect()->route('admin.landing.edit');
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

        Cache::forget('home_features');

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

    public function update(UpdateFeatureRequest $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $data = [];
        if ($request->has('title')) {
            $data['title'] = $request->title;
        }
        if ($request->has('description')) {
            $data['description'] = $request->description;
        }
        if ($request->has('icon_name')) {
            $data['icon_name'] = $request->icon_name;
        }

        if ($request->hasFile('icon') || $request->input('delete_icon') == 1) {
            [$iconPath, $iconName] = $this->featureService->handleIcon($request, $feature);
            $data['icon'] = $iconPath;
            $data['icon_name'] = $iconName;
        }

        if ($request->has('sort_order')) {
            $totalFeatures = Feature::count();
            $newPosition = $this->featureService->getClampedPosition($request->sort_order, $totalFeatures);
            $this->featureService->reorder($feature->sort_order, $newPosition, $feature->id);
            $data['sort_order'] = $newPosition;
        }

        if ($data) {
            $feature->update($data);
        }

        Cache::forget('home_features');

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

        Cache::forget('home_features');

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
        Cache::forget('home_features');
        return response()->json(['success' => true]);
    }
}
