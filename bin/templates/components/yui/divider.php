<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label']);

$label = $props['label'] ?? null;
$content = $slot ?: $label;

// Default class
$class = $class ?: 'flex items-center my-4';

if ($content) {
    echo "
            <div class=\"$class\" $extras>
                <span class=\"flex-grow h-px bg-gray-300\"></span>
                <span class=\"px-3 text-gray-500 text-sm\">$content</span>
                <span class=\"flex-grow h-px bg-gray-300\"></span>
            </div>
        ";
}

echo "<div class=\"h-px bg-gray-300 my-4\" $extras></div>";
// };
