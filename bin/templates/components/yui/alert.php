<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['type']);

$type = $props['type'] ?? "info";

$colors = [
    'info'    => 'bg-blue-50 text-blue-800 border-blue-300',
    'success' => 'bg-green-50 text-green-800 border-green-300',
    'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-300',
    'error'   => 'bg-red-50 text-red-800 border-red-300',
];

$class = $class ?: "border px-4 py-3 rounded-lg " . ($colors[$type] ?? $colors['info']);

echo "<div class=\"$class\" $extras>$slot</div>";
// };
