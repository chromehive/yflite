<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'description']);

$title = $props['title'] ?? '';
$desc  = $props['description'] ?? '';
$class = $props['class'] ?? 'p-4 border rounded-lg bg-white dark:bg-gray-800';

$descHtml = $desc ? "<p class=\"text-xs text-gray-500\">$desc</p>" : '';

echo "
        <div class=\"$class\" $extras>
            <div class=\"mb-3\">
                <h3 class=\"font-semibold\">$title</h3>
                $descHtml
            </div>
            <div class=\"w-full h-64\">
                $slot
            </div>
        </div>
    ";
// };
