<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['icon', 'active']);

$icon   = $props['icon'] ?? 'circle';
$active = $props['active'] ?? false;

$class = $class ?: '
        flex flex-col items-center justify-center text-xs
        text-gray-600 hover:text-blue-600
        data-[active=true]:text-blue-600
    ';

echo "
        <button class=\"$class\" data-active=\"" . ($active ? 'true' : 'false') . "\" $extras>
            <span class=\"material-icons text-2xl\">$icon</span>
            <span>$slot</span>
        </button>
    ";
// };