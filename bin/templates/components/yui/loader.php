<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['size']);

$size = $props['size'] ?? '6';
$class = $props['class'] ?? 'animate-spin mx-auto text-blue-600';

echo "
        <svg class=\"h-$size w-$size $class\" viewBox=\"0 0 24 24\" fill=\"none\">
            <circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle>
            <path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z\"></path>
        </svg>
    ";
// };
