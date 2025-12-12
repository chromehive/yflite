<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'subtitle']);

$title    = $props['title'] ?? null;
$subtitle = $props['subtitle'] ?? null;

$class = $class ?: "mb-6";

echo "
        <header class=\"$class\" $extras>
            " . ($title ? "<h1 class=\"text-2xl font-bold\">$title</h1>" : "") . "
            " . ($subtitle ? "<p class=\"text-gray-600\">$subtitle</p>" : "") . "
            $slot
        </header>
    ";
// };
