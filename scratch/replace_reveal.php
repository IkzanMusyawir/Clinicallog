<?php
$file = 'c:\\TUGAS PI\\Laravel\\clinicallog-cms\\resources\\views\\landing.blade.php';
$content = file_get_contents($file);

// Replace " reveal" or "reveal " with empty, and add data-aos
$content = preg_replace('/class="([^"]*)\breveal\b([^"]*)"/', 'class="$1$2" data-aos="fade-up"', $content);
// Clean up double spaces in class
$content = preg_replace('/class="\s+/', 'class="', $content);
$content = preg_replace('/\s+"/', '"', $content);
$content = preg_replace('/class="([^"]+)\s+([^"]+)"/', 'class="$1 $2"', $content);

file_put_contents($file, $content);
echo "Replaced reveal with data-aos=fade-up";
