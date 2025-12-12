<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['placeholder']);

$placeholder = $props['placeholder'] ?? "Search…";
$class = $class ?: "relative";

echo "
<div x-data=\"{ open:false, query:'' }\" class=\"$class\" $extras>
    <input
        type=\"text\"
        x-model=\"query\"
        @focus=\"open=true\"
        @keydown.escape=\"open=false\"
        placeholder=\"$placeholder\"
        class=\"w-full border rounded-lg px-3 py-2\"
    />

    <div
        x-show=\"open\"
        x-transition
        @click.outside=\"open=false\"
        class=\"absolute z-50 left-0 right-0 mt-1 bg-white dark:bg-gray-800 border rounded-lg shadow-lg max-h-60 overflow-auto\"
    >
        $slot
    </div>
</div>
    ";
// };
