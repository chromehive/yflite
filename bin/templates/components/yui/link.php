<?php
// return function($props){
// var_dump($props);
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['href', 'label']);

$href  = $props['href'] ?? '#';
$label = $props['label'] ?? null;

$class = $class ?: 'text-blue-600 hover:underline';

$content = $slot ?: $label;

echo "
        <a href=\"$href\" class=\"$class\" $extras>
            $content
        </a>
    ";
// };