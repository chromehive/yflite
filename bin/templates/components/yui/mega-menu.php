<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['sections']);

$sections = $props['sections'] ?? [];
$class = $class ?: "relative group";

$cols = "";
foreach ($sections as $section => $links) {
    $list = "";
    foreach ($links as $label => $href) {
        $list .= "<a href=\"$href\" class='block text-gray-700 hover:underline'>$label</a>";
    }

    $cols .= "
            <div>
                <h4 class='font-semibold mb-2'>$section</h4>
                <div class='space-y-1'>$list</div>
            </div>
        ";
}

echo "
        <div class=\"$class\" $extras>
            <div class=\"hidden group-hover:flex absolute left-0 top-full bg-white border shadow p-6 gap-8 z-50\">
                $cols
            </div>
            $slot
        </div>
    ";
// };
