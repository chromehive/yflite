<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['items']);

$items = $props['items'] ?? [];  // ['Dashboard'=>'/dashboard', 'Users'=>'/users', 'Add'=>'']
$class = $class ?: 'flex items-center space-x-2 text-sm text-gray-600';

$html = "<nav class=\"$class\" $extras>";

$total = count($items);
$index = 0;

foreach ($items as $label => $href) {
    $isLast = $index === $total - 1;

    if (!$isLast) {
        $html .= "
                <a href=\"$href\" class=\"hover:text-gray-900\">$label</a>
                <span class=\"text-gray-400\">/</span>
            ";
    } else {
        $html .= "<span class=\"text-gray-900 font-medium\">$label</span>";
    }

    $index++;
}

echo $html . "</nav>";
// };
