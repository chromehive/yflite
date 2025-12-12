<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['show', 'timeout']);

$show = $props['show'] ?? "false";
$timeout = $props['timeout'] ?? 2500;

$class = $class ?:
    "fixed bottom-4 right-4 bg-gray-900 text-white px-4 py-2 rounded shadow";

echo "
<div x-data=\"{ show: $show }\"
     x-show=\"show\"
     x-transition
     x-init=\"if(show){ setTimeout(()=>show=false, $timeout) }\"
     class=\"$class\"
     $extras>
     $slot
</div>
    ";
// };
