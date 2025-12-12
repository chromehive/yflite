<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open', 'placeholder']);

$open        = $props['open'] ?? "false";
$placeholder = $props['placeholder'] ?? "Search commands...";

$class = $class ?: "fixed inset-0 flex items-start justify-center pt-20 z-50";

echo "
<div x-data=\"{ open: $open, query:'' }\" $extras>
    <div
        class=\"fixed inset-0 bg-black/50\"
        x-show=\"open\" x-transition.opacity
        @click=\"open=false\">
    </div>

    <div class=\"$class\" x-show=\"open\" x-transition>
        <div class=\"w-full max-w-lg bg-white dark:bg-gray-800 shadow-lg rounded-xl p-4\">
            <input
                type=\"text\"
                x-model=\"query\"
                placeholder=\"$placeholder\"
                class=\"w-full border px-3 py-2 rounded mb-3\"
            />
            <div class=\"max-h-60 overflow-y-auto divide-y\">
                $slot
            </div>
        </div>
    </div>
</div>
    ";
// };
