<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'value', 'icon', 'description']);

$title = $props['title'] ?? 'Stat';
$value = $props['value'] ?? '0';
$icon  = $props['icon'] ?? '';
$desc  = $props['description'] ?? '';
$class = $props['class'] ?? 'p-4 border rounded shadow-sm bg-white';

$iconHtml = $icon ? "<div class=\"text-3xl mb-2\">$icon</div>" : '';

echo "
        <div class=\"$class\">
            $iconHtml
            <div class=\"text-sm text-gray-500\">$title</div>
            <div class=\"text-2xl font-bold\">$value</div>
            <div class=\"text-xs text-gray-400 mt-1\">$desc</div>
        </div>
    ";
// };
