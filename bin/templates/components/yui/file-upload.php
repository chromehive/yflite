<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['name', 'label', 'accept']);

$name   = $props['name'] ?? 'file';
$label  = $props['label'] ?? 'Upload file';
$accept = $props['accept'] ?? '*/*';
$id     = uniqid('file_');

$class = $class ?: "
        flex flex-col items-center justify-center gap-2 p-6 border-2 border-dashed
        rounded cursor-pointer bg-gray-50 hover:bg-gray-100 text-gray-600
    ";

echo "
        <label for=\"$id\" class=\"$class\" $extras>
            <input
                type=\"file\"
                name=\"$name\"
                id=\"$id\"
                accept=\"$accept\"
                class=\"hidden\"
            >
            <div class=\"text-sm\">$label</div>
        </label>
    ";
// };
