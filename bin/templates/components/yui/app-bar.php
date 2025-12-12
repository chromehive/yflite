<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title']);

$title = $props['title'] ?? null;

$class = $class ?: '
        w-full h-14 bg-white border-b flex items-center
        justify-between px-4 shadow-sm
    ';

echo "
        <header class=\"$class\" $extras>
            <div class=\"flex items-center gap-3\">
                $title
            </div>
            <div class=\"flex items-center gap-2\">
                $slot
            </div>
        </header>
    ";
// };