<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'min',
    'max',
    'step',
    'value',
    'name',
    'id',
    'label'
]);

$id    = $props['id'] ?? uniqid('slider_');
$name  = $props['name'] ?? $id;
$min   = $props['min'] ?? 0;
$max   = $props['max'] ?? 100;
$step  = $props['step'] ?? 1;
$value = $props['value'] ?? ($min + (($max - $min) / 2));
$label = $props['label'] ?? null;

$class = $class ?: "w-full accent-blue-600";

$labelHtml = $label
    ? "<label for=\"$id\" class=\"block mb-1 text-sm font-medium\">$label</label>"
    : "";

echo "
        $labelHtml
        <input
            type=\"range\"
            id=\"$id\"
            name=\"$name\"
            min=\"$min\"
            max=\"$max\"
            step=\"$step\"
            value=\"$value\"
            class=\"$class\"
            $extras
        >
    ";
// };
