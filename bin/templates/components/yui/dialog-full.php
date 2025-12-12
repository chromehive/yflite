
<?php
// return function($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open']);

$open = $props['open'] === 'true' ? 'true' : 'false';

$class = $class ?: 'w-full h-full bg-white p-6 overflow-auto';

echo "
        <div
            x-data=\"{ open: $open }\"
            x-show=\"open\"
            class=\"fixed inset-0 bg-white z-50\"
            x-cloak
            $extras
        >
            $slot
        </div>
    ";
// };