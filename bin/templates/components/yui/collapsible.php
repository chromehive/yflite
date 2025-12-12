<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'open']);

$title = $props['title'] ?? "Section";
$open  = $props['open'] ?? "false";

$class = $class ?: "border rounded-lg";

echo "
        <div x-data=\"{ open: $open }\" class=\"$class\" $extras>
            <button
                class=\"w-full flex justify-between items-center p-3 font-medium\"
                @click=\"open = !open\"
            >
                <span>$title</span>
                <span x-text=\"open ? '−' : '+'\"></span>
            </button>

            <div x-show=\"open\" x-collapse>
                <div class=\"p-3\">
                    $slot
                </div>
            </div>
        </div>
    ";
// };
