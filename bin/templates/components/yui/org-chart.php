<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['root']);

$root = $props['root'] ?? 'CEO';

$class = $class ?: 'flex flex-col items-center';

echo "
        <div class=\"$class\" $extras>
            <div class='p-3 bg-blue-600 text-white rounded-lg shadow mb-6'>
                $root
            </div>

            <div class='flex gap-6'>
                $slot
            </div>
        </div>
    ";
// };
