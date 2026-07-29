<?php

namespace App\Services;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureService
{
    public function handleIcon(Request $request, Feature $feature): array
    {
        $iconPath = $feature->icon;
        $iconName = $request->icon_name;

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

        if ($request->input('delete_icon') == 1) {
            if ($feature->icon) {
                Storage::disk('public')->delete($feature->icon);
            }
            $iconPath = null;
            $iconName = null;
        }

        return [$iconPath, $iconName];
    }

    public function handleIconForNew(Request $request): array
    {
        $iconPath = null;
        $iconName = $request->icon_name;

        if (empty($iconName) && $request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('features', 'public');
        }

        return [$iconPath, $iconName];
    }

    public function getClampedPosition(?int $sortOrder, int $total, bool $isNew = false): int
    {
        $max = $isNew ? $total + 1 : $total;
        if ($sortOrder === null) {
            return $max;
        }
        $position = (int) $sortOrder;
        if ($position < 1) $position = 1;
        if ($position > $max) $position = $max;
        return $position;
    }

    public function shiftForNewItem(int $newPosition): void
    {
        Feature::where('sort_order', '>=', $newPosition)
            ->orderBy('sort_order', 'desc')
            ->each(function ($f) {
                $f->update(['sort_order' => $f->sort_order + 1]);
            });
    }

    public function reorder(int $oldPosition, int $newPosition, int $featureId): void
    {
        if ($oldPosition === $newPosition) return;

        if ($newPosition < $oldPosition) {
            Feature::where('id', '!=', $featureId)
                ->whereBetween('sort_order', [$newPosition, $oldPosition - 1])
                ->orderBy('sort_order', 'desc')
                ->each(function ($f) {
                    $f->update(['sort_order' => $f->sort_order + 1]);
                });
        } else {
            Feature::where('id', '!=', $featureId)
                ->whereBetween('sort_order', [$oldPosition + 1, $newPosition])
                ->orderBy('sort_order', 'asc')
                ->each(function ($f) {
                    $f->update(['sort_order' => $f->sort_order - 1]);
                });
        }
    }

    public function compactAfterDelete(int $deletedPosition): void
    {
        Feature::where('sort_order', '>', $deletedPosition)
            ->orderBy('sort_order', 'asc')
            ->each(function ($f) {
                $f->update(['sort_order' => $f->sort_order - 1]);
            });
    }
}
