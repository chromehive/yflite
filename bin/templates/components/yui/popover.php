<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['trigger']);

$trigger = $props['trigger'] ?? "Click me";

$class = $class ?: "absolute z-50 mt-2 p-3 bg-white dark:bg-gray-800 shadow-lg rounded-lg border";

echo "
        <div x-data=\"{ open:false }\" class=\"relative inline-block\" $extras>
            <button @click=\"open = !open\" class=\"font-medium\">$trigger</button>

            <div
                x-show=\"open\"
                @click.outside=\"open=false\"
                x-transition
                class=\"$class\"
            >
                $slot
            </div>
        </div>
    ";
// };
