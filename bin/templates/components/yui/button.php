<?php
// return function ($props) {
// var_dump($props);
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label', 'type']);

$label = $props['label'] ?? null;
$type  = $props['type'] ?? 'button';

// Default class if none passed
$class = $class ?: 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition';

$content = $slot ?: $label;

// $extras = htmlspecialchars($extras);
// var_dump($extras);
// exit;

echo "
        <button type=\"$type\" class=\"$class\" $extras>
            $content
        </button>
    ";
// };
