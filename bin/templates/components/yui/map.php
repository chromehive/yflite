<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['id', 'height']);

$id     = $props['id']     ?? 'map';
$height = $props['height'] ?? '350px';

$class = $class ?: 'w-full rounded overflow-hidden border';

echo "
        <div id=\"$id\" class=\"$class\" style=\"height:$height\" $extras>
            $slot
        </div>
    ";
// };
