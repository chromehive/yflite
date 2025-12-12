<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open', 'height']);

$open    = ($props['open'] ?? 'false') === 'true';
$height  = $props['height'] ?? '260px';

$class = $class ?: 'fixed bottom-0 left-0 right-0 bg-gray-900 text-white border-t shadow-xl transition-transform duration-300';

$transform = $open ? 'translate-y-0' : 'translate-y-full';

echo "
        <div class=\"$class $transform\" style=\"height:$height\" $extras>
            <div class=\"p-3 border-b border-gray-700\">
                <span class=\"text-sm text-gray-300\">Panel</span>
            </div>
            <div class=\"p-3 h-[calc(100%-40px)] overflow-auto\">
                $slot
            </div>
        </div>
    ";
// };
