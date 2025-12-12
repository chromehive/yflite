<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open']);

$open = $props['open'] ?? true;

$class = $class ?: "w-64 bg-gray-100 border-r transition-all duration-300";

$style = $open ? "width: 16rem;" : "width: 0; overflow: hidden;";

echo "
        <aside class=\"$class\" style=\"$style\" $extras>
            $slot
        </aside>
    ";
// };
