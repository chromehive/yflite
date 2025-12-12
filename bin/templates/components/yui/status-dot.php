<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['size', 'color']);

$size  = $props['size'] ?? '3';
$color = $props['color'] ?? 'green';
$class = $props['class'] ?? '';

$map = [
    'green'  => 'bg-green-500',
    'red'    => 'bg-red-500',
    'yellow' => 'bg-yellow-500',
    'gray'   => 'bg-gray-400',
    'blue'   => 'bg-blue-500'
];

$dotClass = "h-$size w-$size rounded-full " . ($map[$color] ?? $map['gray']);

return "<span class=\"$dotClass $class\"></span>";
// };
