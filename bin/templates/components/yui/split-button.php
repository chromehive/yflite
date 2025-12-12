<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label']);

$label = $props['label'] ?? null;

$class = $class ?: 'inline-flex items-center border rounded-md overflow-hidden bg-white shadow-sm';

echo "
        <div class=\"$class\" x-data=\"{ open: false }\" $extras>
            <button class=\"px-4 py-2 bg-blue-600 text-white\">
                $slot
            </button>

            <button
                @click=\"open = !open\"
                class=\"px-3 py-2 border-l bg-blue-700 text-white flex items-center justify-center\">
                <i class=\"fa-solid fa-chevron-down\"></i>&dArr;
            </button>

            <div
                x-show=\"open\"
                @click.outside=\"open=false\"
                class=\"absolute mt-2 bg-white border rounded-md shadow-md py-2 right-0 w-40 z-40\">
                <slot name=\"menu\"></slot>
            </div>
        </div>
    ";
// };