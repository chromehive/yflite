<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['brand', 'links']);

$brand = $props['brand'] ?? 'Brand';
$links = $props['links'] ?? [];
$class = $class ?: "flex items-center justify-between p-4 bg-gray-100 border-b";

$nav = "";
foreach ($links as $label => $href) {
    $nav .= "<a href=\"$href\" class=\"text-gray-700 hover:underline\">$label</a>";
}

echo "
        <header class=\"$class\" $extras>
            <div class=\"font-semibold text-lg\">$brand</div>
            <nav class=\"flex items-center gap-4\">
                $nav
            </nav>
            $slot
        </header>
    ";
// };
