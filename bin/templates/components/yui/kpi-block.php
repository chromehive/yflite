<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['label', 'value', 'trend', 'icon']);

$label = $props['label'] ?? '';
$value = $props['value'] ?? '';
$trend = $props['trend'] ?? ''; // e.g. +12%, -3%
$icon  = $props['icon'] ?? '';
$class = $props['class'] ?? 'p-4 rounded-lg border bg-white dark:bg-gray-800';

// If slot exists, it overrides everything
if ($slot) return "<div class=\"$class\" $extras>$slot</div>";

$iconHtml = $icon ? "<div class=\"text-3xl mb-2\">$icon</div>" : '';
$trendHtml = $trend ? "<span class=\"text-xs text-gray-500 ml-2\">$trend</span>" : '';

echo "
        <div class=\"$class\" $extras>
            $iconHtml
            <div class=\"text-sm text-gray-500\">$label</div>
            <div class=\"text-2xl font-bold flex items-center\">
                $value
                $trendHtml
            </div>
        </div>
    ";
// };
