<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'label',
    'options',
    'name'
]);

$label   = $props['label'] ?? null;
$name    = $props['name'] ?? null;
$options = $props['options'] ?? []; // ['Ghana' => 'gh', 'Nigeria' => 'ng']

$class = $class ?: "
        w-full px-3 py-2 border rounded-lg
        bg-white dark:bg-gray-800
        border-gray-300 dark:border-gray-700
        focus:outline-none focus:ring-2 focus:ring-blue-500
    ";

$labelHtml = $label
    ? "<label class='block mb-1 font-medium text-sm text-gray-700'>$label</label>"
    : '';

$optionsHtml = '';
foreach ($options as $text => $value) {
    $optionsHtml .= "<option value=\"$value\">$text</option>";
}

echo "
        <div>
            $labelHtml
            <select name=\"$name\" class=\"$class\" $extras>
                $optionsHtml
                $slot
            </select>
        </div>
    ";
// };
