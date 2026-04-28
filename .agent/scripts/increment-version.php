<?php

$path = __DIR__ . '/../../version.json';
$content = file_get_contents($path);
$version = json_decode($content, true);

// Get arguments from CLI
$type = $argv[1] ?? 'patch';

if ($type === 'minor') {
    $version['minor']++;
    $version['patch'] = 0;
} else {
    $version['patch']++;
}

// Ensure middle constraint doesn't exceed 9 unless it's a "sometimes every constraint will be 2 digit number"
// But the user said "until i say its the final version its not going to be version 3"
// and "v2 but written as 2.0.0 to 2.9.9 or maybe 3"
// "somtimes every constraint will be 2 digit number like 2.6.33"

file_put_contents($path, json_encode($version, JSON_PRETTY_PRINT));

$newVersionStr = "v{$version['major']}.{$version['minor']}.{$version['patch']}";

// Update footer.blade.php
$footerPath = __DIR__ . '/../../resources/views/livewire/frontend/components/footer.blade.php';
if (file_exists($footerPath)) {
    $footerContent = file_get_contents($footerPath);
    // Regex matches 'v2.0.1' style patterns inside the footer span
    $pattern = '/v\d+\.\d+\.\d+/';
    $newFooterContent = preg_replace($pattern, $newVersionStr, $footerContent);
    file_put_contents($footerPath, $newFooterContent);
    echo "Footer updated with hardcoded version: $newVersionStr\n";
}

echo "Version updated to: $newVersionStr\n";
