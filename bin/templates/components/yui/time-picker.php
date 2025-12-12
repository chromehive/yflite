<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['name', 'value']);

$name  = $props['name']  ?? 'time';
$value = $props['value'] ?? '';

$class = $class ?: 'border rounded-md px-3 py-2 w-full';

echo "
        <input type=\"time\" name=\"$name\" value=\"$value\" class=\"$class\" $extras>
    ";
// };