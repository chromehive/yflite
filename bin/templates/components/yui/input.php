<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['type', 'value', 'placeholder', 'label', 'name']);

$type        = $props['type'] ?? 'text';
$value       = $props['value'] ?? '';
$placeholder = $props['placeholder'] ?? '';
$label       = $props['label'] ?? null;
$name        = $props['name'] ?? null;

$class = $class ?: "w-full px-3 py-2 border rounded-lg bg-white dark:bg-gray-800
                       border-gray-300 dark:border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500";

$labelHtml = $label
    ? "<label class=\"block mb-1 font-medium text-sm text-gray-700\">$label</label>"
    : "";

echo "
        <div>
            $labelHtml
            <input
                type=\"$type\"
                name=\"$name\"
                value=\"$value\"
                placeholder=\"$placeholder\"
                class=\"$class\"
                $extras
            >
        </div>
    ";
// };
