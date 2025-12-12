<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['text', 'placement']);

$text = $props['text'] ?? 'Tooltip';
$placement = $props['placement'] ?? 'top';

$positions = [
    'top'    => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
    'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
    'left'   => 'right-full top-1/2 -translate-y-1/2 mr-2',
    'right'  => 'left-full top-1/2 -translate-y-1/2 ml-2'
];

$pos = $positions[$placement] ?? $positions['top'];

echo "
<div x-data=\"{ show: false }\" class=\"relative inline-block\" $extras>

    <div @mouseenter=\"show = true\" @mouseleave=\"show = false\">
        $slot
    </div>

    <div
        x-show=\"show\"
        x-transition
        class=\"absolute $pos px-2 py-1 text-xs bg-gray-800 text-white rounded shadow whitespace-nowrap\"
    >
        $text
    </div>

</div>
    ";
// };
