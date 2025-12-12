<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props);

$class = $class ?: 'inline-flex items-center rounded-md shadow-sm border border-gray-300 overflow-hidden';

echo "
        <div class=\"$class\" $extras>
            $slot
        </div>
    ";
// };