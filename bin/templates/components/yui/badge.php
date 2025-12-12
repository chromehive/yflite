<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label', 'variant']);

$label   = $props['label'] ?? null;
$variant = $props['variant'] ?? 'gray';

// variants
$variants = [
    'gray'   => 'bg-gray-200 text-gray-800',
    'blue'   => 'bg-blue-100 text-blue-700',
    'green'  => 'bg-green-100 text-green-700',
    'red'    => 'bg-red-100 text-red-700',
    'yellow' => 'bg-yellow-100 text-yellow-700',
    'purple' => 'bg-purple-100 text-purple-700',
];

$defaultClass = "px-2 py-0.5 rounded text-xs font-semibold " . ($variants[$variant] ?? $variants['gray']);
$class = trim($defaultClass . " " . $class);

$content = $slot ?: $label;

echo "<span class=\"$class\" $extras>$content</span>";
// };
