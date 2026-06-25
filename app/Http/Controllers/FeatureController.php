<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.landing.edit');
    }

    public function create()
    {
        $totalFeatures = Feature::count();
        return view('admin.features.form', compact('totalFeatures'));
    }

    public function store(Request $request)
    {
        $iconPath = null;
        $iconName = $request->icon_name;

        // If using Lucide icon name, no need for file upload
        if (empty($iconName) && $request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('features', 'public');
        }

        $totalFeatures = Feature::count();
        $newPosition = (int) $request->sort_order;

        // Clamp position: min 1, max totalFeatures + 1 (new item)
        if ($newPosition < 1) $newPosition = 1;
        if ($newPosition > $totalFeatures + 1) $newPosition = $totalFeatures + 1;

        // Shift features at and after this position down
        Feature::where('sort_order', '>=', $newPosition)
            ->orderBy('sort_order', 'desc')
            ->each(function ($f) {
                $f->update(['sort_order' => $f->sort_order + 1]);
            });

        Feature::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $iconPath,
            'icon_name' => $iconName,
            'sort_order' => $newPosition,
        ]);

        return redirect()->route('admin.landing.edit')->with('success', 'Feature berhasil ditambahkan');
    }

    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        $totalFeatures = Feature::count();
        return view('admin.features.form', compact('feature', 'totalFeatures'));
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $iconPath = $feature->icon;
        $iconName = $request->icon_name;

        // If icon_name is provided, clear uploaded icon
        if (!empty($iconName)) {
            if ($feature->icon) {
                Storage::disk('public')->delete($feature->icon);
            }
            $iconPath = null;
        } elseif ($request->hasFile('icon')) {
            if ($feature->icon) {
                Storage::disk('public')->delete($feature->icon);
            }
            $iconPath = $request->file('icon')->store('features', 'public');
            $iconName = null;
        }

        // Handle delete icon checkbox
        if ($request->input('delete_icon') == 1) {
            if ($feature->icon) {
                Storage::disk('public')->delete($feature->icon);
            }
            $iconPath = null;
            $iconName = null;
        }

        // Handle sort_order reordering
        $oldPosition = $feature->sort_order;
        $totalFeatures = Feature::count();
        $newPosition = (int) ($request->sort_order ?? $oldPosition);

        // Clamp position
        if ($newPosition < 1) $newPosition = 1;
        if ($newPosition > $totalFeatures) $newPosition = $totalFeatures;

        if ($oldPosition !== $newPosition) {
            if ($newPosition < $oldPosition) {
                // Moving up: shift features between newPos and oldPos-1 down by 1
                Feature::where('id', '!=', $feature->id)
                    ->whereBetween('sort_order', [$newPosition, $oldPosition - 1])
                    ->orderBy('sort_order', 'desc')
                    ->each(function ($f) {
                        $f->update(['sort_order' => $f->sort_order + 1]);
                    });
            } else {
                // Moving down: shift features between oldPos+1 and newPos up by 1
                Feature::where('id', '!=', $feature->id)
                    ->whereBetween('sort_order', [$oldPosition + 1, $newPosition])
                    ->orderBy('sort_order', 'asc')
                    ->each(function ($f) {
                        $f->update(['sort_order' => $f->sort_order - 1]);
                    });
            }
        }

        $feature->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $iconPath,
            'icon_name' => $iconName,
            'sort_order' => $newPosition,
        ]);

        return redirect()->route('admin.landing.edit')->with('success', 'Feature berhasil diupdate');
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        $deletedPosition = $feature->sort_order;

        // Clean up uploaded icon file if exists
        if ($feature->icon) {
            Storage::disk('public')->delete($feature->icon);
        }

        $feature->delete();

        // Shift features after deleted position up by 1
        Feature::where('sort_order', '>', $deletedPosition)
            ->orderBy('sort_order', 'asc')
            ->each(function ($f) {
                $f->update(['sort_order' => $f->sort_order - 1]);
            });

        return redirect()->route('admin.landing.edit')->with('success', 'Feature berhasil dihapus');
    }
}
