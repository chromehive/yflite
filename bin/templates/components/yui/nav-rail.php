<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, []);

$class = $class ?: '
        h-screen w-20 bg-white border-r flex flex-col items-center py-4 gap-6
    ';

echo "
        <nav class=\"$class\" $extras>
            $slot
        </nav>
    ";
// };