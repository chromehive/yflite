<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['icon']);

$icon = $props['icon'] ?? null;

$class = $class ?: '
        fixed bottom-6 right-6 w-14 h-14 rounded-full flex items-center justify-center
        shadow-lg bg-blue-600 text-white
    ';

$content = $slot ?: "<span class=\"material-icons\">$icon</span>";

echo "
        <button class=\"$class\" $extras>
            $content
        </button>
    ";
// };