<?php

/**
 * Cache & Bootstrap Cleaner Script for Deployment / Hosting Servers.
 * Delete this file after running on production for security.
 */

$baseDir = __DIR__ . '/..';

echo "<h2>Laravel Cache & Bootstrap Cleaner</h2>";

$filesToDelete = [
    $baseDir . '/bootstrap/cache/config.php',
    $baseDir . '/bootstrap/cache/routes.php',
    $baseDir . '/bootstrap/cache/services.php',
    $baseDir . '/bootstrap/cache/packages.php',
];

foreach ($filesToDelete as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "<p style='color:green;'>[DELETED] " . htmlspecialchars($file) . "</p>";
        } else {
            echo "<p style='color:red;'>[ERROR] Failed to delete " . htmlspecialchars($file) . "</p>";
        }
    } else {
        echo "<p style='color:gray;'>[NOT FOUND] " . htmlspecialchars(basename($file)) . " (Clean)</p>";
    }
}

// Clear compiled views
$viewDir = $baseDir . '/storage/framework/views';
if (is_dir($viewDir)) {
    $views = glob($viewDir . '/*.php');
    foreach ($views as $view) {
        @unlink($view);
    }
    echo "<p style='color:green;'>[CLEARED] " . count($views) . " compiled Blade views cleared.</p>";
}

echo "<hr><p style='color:blue;'><strong>Done! Try reloading your application URL now.</strong></p>";
