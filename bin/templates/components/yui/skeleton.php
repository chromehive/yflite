<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, []);

$class = $props['class'] ?? 'w-full h-4 bg-gray-200 animate-pulse rounded';

echo "<div class=\"$class\"></div>";
// };
