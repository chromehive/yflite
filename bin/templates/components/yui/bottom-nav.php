<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, []);

$class = $class ?: 'fixed bottom-0 inset-x-0 bg-white border-t shadow-lg flex justify-around items-center py-2 z-50';
// var_dump($slot);

echo "
    <nav class=\"$class\" $extras>
        $slot
    </nav>
";
// };