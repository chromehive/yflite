<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['items']);

$items = $props['items'] ?? [];
$class = $props['class'] ?? 'relative border-l pl-6';

$out = "<div class=\"$class\">";

foreach ($items as $item) {
    $title = $item['title'] ?? '';
    $desc  = $item['description'] ?? '';
    $time  = $item['time'] ?? '';
    $icon  = $item['icon'] ?? '⦿';
    $color = $item['color'] ?? 'blue-600';

    $out .= "
            <div class=\"mb-8\">
                <div class=\"absolute -left-3 top-1 h-6 w-6 flex items-center justify-center text-$color\">
                    $icon
                </div>
                <h3 class=\"font-semibold\">$title</h3>
                <p class=\"text-gray-600 text-sm\">$desc</p>
                <span class=\"text-xs text-gray-400\">$time</span>
            </div>
        ";
}

$out .= "</div>";
return $out;
// };
