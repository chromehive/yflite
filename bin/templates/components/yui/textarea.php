<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'label',
    'placeholder',
    'name',
    'rows'
]);

$label       = $props['label'] ?? null;
$placeholder = $props['placeholder'] ?? '';
$name        = $props['name'] ?? '';
$rows        = $props['rows'] ?? 4;

$class = $class ?: "
        w-full px-3 py-2 border rounded-lg
        bg-white dark:bg-gray-800
        border-gray-300 dark:border-gray-700
        focus:outline-none focus:ring-2 focus:ring-blue-500
    ";

$content = $slot ?: '';

$labelHtml = $label
    ? "<label class='block mb-1 font-medium text-sm text-gray-700'>$label</label>"
    : '';

echo "
        <div>
            $labelHtml
            <textarea
                name=\"$name\"
                rows=\"$rows\"
                placeholder=\"$placeholder\"
                class=\"$class\"
                $extras>$content</textarea>
        </div>
    ";
// };
