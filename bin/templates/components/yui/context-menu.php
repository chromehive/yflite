<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['target']);

$class = $class ?:
    "absolute z-50 min-w-40 bg-white dark:bg-gray-800 border shadow-lg rounded-lg";

echo "
<div x-data=\"{ open:false, x:0, y:0 }\"
     @contextmenu.prevent=\"open=true; x=\$event.clientX; y=\$event.clientY\"
     $extras>

    <div
        x-show=\"open\"
        @click.outside=\"open=false\"
        x-transition
        class=\"$class\"
        :style=\"`top:${y}px; left:${x}px`\">
        $slot
    </div>
</div>
    ";
// };
