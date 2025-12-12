<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'label',
    'name',
    'value',
    'checked'
]);

$label   = $props['label'] ?? null;
$name    = $props['name'] ?? '';
$value   = $props['value'] ?? '';
$checked = isset($props['checked']) ? 'checked' : '';

$class = $class ?: "text-blue-600 border-gray-300 focus:ring-blue-500";

$content = $slot ?: $label;

echo "
        <label class=\"flex items-center space-x-2 cursor-pointer\">
            <input type=\"radio\" name=\"$name\" value=\"$value\" class=\"$class\" $checked $extras>
            <span class=\"text-gray-700\">$content</span>
        </label>
    ";
// };
