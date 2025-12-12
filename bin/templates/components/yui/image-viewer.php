<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['src', 'alt']);

$src   = $props['src'] ?? '';
$alt   = $props['alt'] ?? '';
$class = $props['class'] ?? 'cursor-pointer';

$thumbnail = $slot ?: "<img src=\"$src\" alt=\"$alt\" class=\"w-full rounded\" />";

echo "
        <div x-data=\"{open:false}\" $extras>
            <div @click=\"open=true\" class=\"$class\">
                $thumbnail
            </div>

            <div
                x-show=\"open\"
                @click=\"open=false\"
                @keydown.escape.window=\"open=false\"
                class=\"fixed inset-0 bg-black/70 flex items-center justify-center p-4 z-50\"
                x-transition
            >
                <img src=\"$src\" alt=\"$alt\" class=\"max-w-full max-h-full rounded-lg shadow-lg\">
            </div>
        </div>
    ";
// };
