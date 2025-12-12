<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['value']);

$value = $props['value'] ?? '';

$class = $class ?: '
        px-4 py-2 cursor-pointer select-none
        text-gray-700 hover:bg-gray-100
        data-[active=true]:bg-blue-600 data-[active=true]:text-white
    ';

echo "
        <button
            @click=\"value = '$value'\"
            :data-active=\"value === '$value'\"
            class=\"$class\"
            $extras
        >
            $slot
        </button>
    ";
// };