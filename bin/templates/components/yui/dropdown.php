<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['trigger']);

$trigger = $props['trigger'] ?? '<button>Open</button>';
$class = $class ?: 'bg-white border rounded shadow p-2 min-w-[150px]';

echo "
<div x-data=\"{ open: false }\" class=\"relative inline-block\" $extras>

    <!-- Trigger -->
    <div @click=\"open = !open\">
        $trigger
    </div>

    <!-- Menu -->
    <div
        x-show=\"open\"
        @click.outside=\"open = false\"
        x-transition
        class=\"absolute mt-2 $class\"
    >
        $slot
    </div>

</div>
    ";
// };
