<?php
// return function ($props) {
$base  = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['type']);

$type = $props['type'] ?? 'note';

$styles = [
    'note'    => 'bg-blue-50 border-blue-300 text-blue-800',
    'info'    => 'bg-gray-50 border-gray-300 text-gray-800',
    'success' => 'bg-green-50 border-green-300 text-green-800',
    'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800',
    'error'   => 'bg-red-50 border-red-300 text-red-800',
];

$class = $class ?: "p-4 border-l-4 rounded " . ($styles[$type] ?? $styles['note']);

$content = $slot ?: ($props['message'] ?? 'Important information.');

echo "<div class=\"$class\" $extras>$content</div>";
// };
