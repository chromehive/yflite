<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['icon', 'label']);

$icon  = $props['icon']  ?? null;
$label = $props['label'] ?? null;

$class = $class ?: '
        fixed bottom-6 right-6 inline-flex items-center gap-2 px-4 py-3
        rounded-full shadow-lg bg-blue-600 text-white font-medium
    ';

$iconHtml = $icon ? "<span class=\"material-icons\">$icon</span>" : '';

$content = $slot ?: ($iconHtml . ($label ? "<span>$label</span>" : ''));

echo "
        <button class=\"$class\" $extras>
            $content
        </button>
    ";
// };