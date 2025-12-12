<?php
// return function ($props) {
$base  = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['type', 'message']);

$type  = $props['type'] ?? 'default';
$msg   = $props['message'] ?? null;

$colors = [
    'default' => 'bg-gray-800 text-white',
    'success' => 'bg-green-600 text-white',
    'error'   => 'bg-red-600 text-white',
    'warning' => 'bg-yellow-600 text-black',
    'info'    => 'bg-blue-600 text-white'
];

$class = ($class ?: 'px-4 py-2 rounded shadow-lg fixed bottom-6 left-1/2 transform -translate-x-1/2')
    . ' ' . ($colors[$type] ?? $colors['default']);

$content = $slot ?: $msg;

echo "<div class=\"$class\" $extras>$content</div>";
// };
