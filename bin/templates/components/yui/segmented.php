<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['model']);

$model = $props['model'] ?? 'segmented';

$class = $class ?: 'inline-flex items-center rounded-lg border border-gray-300 overflow-hidden bg-white';

echo "
        <div x-data=\"{ value: '{$model}' }\" class=\"$class\" $extras>
            $slot
        </div>
    ";
// };