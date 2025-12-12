<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['value', 'max', 'barClass']);

$value = (int)($props['value'] ?? 0);
$max   = (int)($props['max'] ?? 100);

$percentage = max(0, min(100, ($value / $max) * 100));

$class = $props['class'] ?? 'w-full h-2 bg-gray-200 rounded';
$barClass = $props['barClass'] ?? 'h-full bg-blue-600 rounded';

echo "
    <div class=\"$class\">
        <div class=\"$barClass\" style=\"width: {$percentage}%\"></div>
    </div>
";
// };
