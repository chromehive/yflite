<?php
// return function($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open', 'title']);

$open = ($props['open'] ?? 'false') === 'true';
$title = $props['title'] ?? '';

$class = $class ?: 'fixed right-0 top-0 h-full w-80 bg-white shadow-xl border-l p-4 transition-transform duration-300';

$transform = $open ? 'translate-x-0' : 'translate-x-full';

echo "
<div class=\"$class $transform\" $extras>
    " . ($title ? "<h2 class='font-semibold mb-3'>$title</h2>" : "") . "
    $slot
</div>
";
// };