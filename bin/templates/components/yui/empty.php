<?php
// return function ($props) {
$base  = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['icon', 'title', 'description']);

$icon  = $props['icon'] ?? '📄';
$title = $props['title'] ?? 'Nothing here yet';
$desc  = $props['description'] ?? 'There is no content to display.';

$class = $class ?: 'text-center p-6 border border-gray-200 rounded';

$content = $slot ?: "
        <div class=\"text-4xl mb-2\">$icon</div>
        <h3 class=\"text-lg font-semibold\">$title</h3>
        <p class=\"text-gray-500\">$desc</p>
    ";

echo "<div class=\"$class\" $extras>$content</div>";
// };
