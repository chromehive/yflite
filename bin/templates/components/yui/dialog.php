<?php
// return function($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open']);

$open = isset($props['open']) && $props['open'] === 'true' ? 'true' : 'false';

$class = $class ?: 'bg-white rounded shadow-lg w-full max-w-md p-4';

echo "
        <div
            x-data=\"{ open: $open }\"
            x-show=\"open\"
            class=\"fixed inset-0 bg-black/50 flex items-center justify-center z-50\"
            x-cloak
        >
            <div class=\"$class\" $extras>
                $slot
            </div>
        </div>
    ";
// };