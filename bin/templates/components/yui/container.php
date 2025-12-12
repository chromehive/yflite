<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, []);

$class = $class ?: "max-w-7xl mx-auto px-4 sm:px-6 lg:px-8";

echo "
        <div class=\"$class\" $extras>
            $slot
        </div>
    ";
// };
