<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'label',
    'help',
    'error',
    'for'
]);

$label = $props['label'] ?? null;
$help  = $props['help']  ?? null;
$error = $props['error'] ?? null;
$for   = $props['for']   ?? null;

$class = $class ?: "mb-4";

$labelHtml = $label
    ? "<label for=\"$for\" class=\"block mb-1 font-medium\">$label</label>"
    : "";

$helpHtml = $help
    ? "<p class=\"text-xs text-gray-500 mt-1\">$help</p>"
    : "";

$errorHtml = $error
    ? "<p class=\"text-xs text-red-600 mt-1\">$error</p>"
    : "";

echo "
        <div class=\"$class\" $extras>
            $labelHtml
            $slot
            $helpHtml
            $errorHtml
        </div>
    ";
// };
