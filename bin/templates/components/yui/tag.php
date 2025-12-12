<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label', 'color']);

$label = $props['label'] ?? null;
$color = $props['color'] ?? 'blue';

$class = $class ?: "inline-flex items-center px-2 py-0.5 text-xs
        rounded-full bg-$color-100 text-$color-700";

$content = $slot ?: $label;

echo "
        <span class=\"$class\" $extras>
            $content
        </span>
    ";
// };
