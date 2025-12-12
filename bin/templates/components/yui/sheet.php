<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open', 'side']);

$open = $props['open'] ?? "false";
$side = $props['side'] ?? "right"; // left or right

$translate = $side === "left"
    ? "-translate-x-full left-0"
    : "translate-x-full right-0";

$class = $class ?:
    "fixed top-0 bottom-0 w-80 bg-white dark:bg-gray-800 shadow-xl transition-transform duration-300";

echo "
        <div x-data=\"{ open: $open }\" $extras>
            <div
                class=\"fixed inset-0 bg-black/40\"
                x-show=\"open\"
                x-transition.opacity
                @click=\"open = false\">
            </div>

            <div
                class=\"$class $translate\"
                :class=\"open ? 'translate-x-0' : '$translate'\"
            >
                $slot
            </div>
        </div>
    ";
// };
