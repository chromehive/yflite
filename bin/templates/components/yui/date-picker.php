<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['name', 'value']);

$name  = $props['name']  ?? '';
$value = $props['value'] ?? '';

$class = $class ?: 'border px-3 py-2 rounded w-full';

echo "
        <input type='date' name=\"$name\" value=\"$value\" class=\"$class\" $extras />
    ";
// };
