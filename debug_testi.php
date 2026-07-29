<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$landing = App\Models\LandingPage::first();
if (!$landing) { echo "No landing page found\n"; exit; }

$testimonials = $landing->testimonials;
if (!$testimonials) { echo "No testimonials\n"; exit; }

echo "=== TESTIMONIALS DATA ===\n";
foreach ($testimonials as $i => $t) {
    echo "[$i] name: " . ($t['name'] ?? '(none)') . "\n";
    echo "    img: " . ($t['img'] ?? '(empty)') . "\n";
    if (!empty($t['img']) && !str_starts_with($t['img'], 'http')) {
        $path = storage_path('app/public/' . $t['img']);
        echo "    file exists: " . (file_exists($path) ? 'YES' : 'NO') . "\n";
        echo "    full path: " . $path . "\n";
        echo "    public url: " . Illuminate\Support\Facades\Storage::disk('public')->url($t['img']) . "\n";
    }
    echo "\n";
}

// Check symlink
$symlinkPath = public_path('storage');
echo "=== STORAGE SYMLINK ===\n";
echo "Symlink path: $symlinkPath\n";
echo "Exists: " . (file_exists($symlinkPath) ? 'YES' : 'NO') . "\n";
echo "Is link: " . (is_link($symlinkPath) ? 'YES' : 'NO') . "\n";
if (is_link($symlinkPath)) {
    echo "Target: " . readlink($symlinkPath) . "\n";
}

// Check testimonials directory
$testiDir = storage_path('app/public/testimonials');
echo "\n=== TESTIMONIALS DIR ===\n";
echo "Dir: $testiDir\n";
echo "Exists: " . (is_dir($testiDir) ? 'YES' : 'NO') . "\n";
if (is_dir($testiDir)) {
    $files = scandir($testiDir);
    echo "Files: " . implode(', ', array_diff($files, ['.', '..'])) . "\n";
}
