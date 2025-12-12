<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['steps', 'current']);

$steps   = $props['steps'] ?? [];
$current = $props['current'] ?? 1;

$class = $class ?: "flex items-center gap-4";

$html = "";
foreach ($steps as $i => $label) {
    $num = $i + 1;
    $stateClass = $num == $current ?
        "bg-blue-600 text-white" :
        "bg-gray-300 text-gray-800";

    $html .= "
            <div class=\"flex items-center gap-2\">
                <div class=\"w-8 h-8 rounded-full flex items-center justify-center $stateClass\">
                    $num
                </div>
                <span>$label</span>
            </div>
        ";
    if ($num < count($steps)) {
        $html .= "<div class=\"flex-1 h-px bg-gray-300\"></div>";
    }
}

echo "
        <div class=\"$class\" $extras>
            $html
            $slot
        </div>
    ";
// };
