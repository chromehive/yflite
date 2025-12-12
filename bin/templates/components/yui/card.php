<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'footer']);

$title  = $props['title'] ?? null;
$footer = $props['footer'] ?? null;

$class = $class ?: 'bg-white dark:bg-gray-800 shadow rounded-lg border p-4';

$headerHtml = $title
    ? "<div class=\"font-semibold text-lg mb-2\">$title</div>"
    : '';

$footerHtml = $footer
    ? "<div class=\"mt-3 border-t pt-2 text-sm\">$footer</div>"
    : '';

echo "
        <div class=\"$class\" $extras>
            $headerHtml
            <div class=\"text-sm\">$slot</div>
            $footerHtml
        </div>
    ";
// };
