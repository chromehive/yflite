<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['src', 'controls', 'poster']);

$src      = $props['src']      ?? null;
$controls = ($props['controls'] ?? 'true') === 'true';
$poster   = $props['poster']   ?? '';

if (!$src) return "<div class='text-red-500 text-sm'>Video src missing.</div>";

$class = $class ?: 'rounded-lg w-full max-h-[500px]';

echo "
        <video src=\"$src\" poster=\"$poster\" " . ($controls ? "controls" : "") . " class=\"$class\" $extras>
            $slot
        </video>
    ";
// };
