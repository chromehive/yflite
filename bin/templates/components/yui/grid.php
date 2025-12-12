<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['cols', 'gap', 'masonry']);

$cols    = $props['cols'] ?? '3';
$gap     = $props['gap'] ?? '4';
$masonry = $props['masonry'] ?? false;

$class = $class ?: (
    $masonry
    ? "columns-$cols gap-$gap"
    : "grid grid-cols-$cols gap-$gap"
);

echo "
        <div class=\"$class\" $extras>
            $slot
        </div>
    ";
// };
