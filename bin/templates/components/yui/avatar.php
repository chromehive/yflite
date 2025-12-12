<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['src', 'initials', 'size']);

$src      = $props['src'] ?? null;
$initials = $props['initials'] ?? null;
$size     = $props['size'] ?? '10';

$class = $class ?: 'rounded-full bg-gray-200 flex items-center justify-center';

// If slot overrides content
if ($slot) {
    return "
            <div class=\"w-$size h-$size overflow-hidden $class\" $extras>
                $slot
            </div>
        ";
}

if ($src) {
    return "
            <img src=\"$src\" class=\"w-$size h-$size object-cover $class\" $extras />
        ";
}

echo "
        <div class=\"w-$size h-$size text-sm font-medium text-gray-700 $class\" $extras>
            $initials
        </div>
    ";
// };
