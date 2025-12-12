<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['items']);

$items = $props['items'] ?? [];
$class = $class ?: 'border rounded divide-y';

$html = '';
foreach ($items as $i => $it) {
    $title = $it['title'] ?? 'Section';
    $content = $it['content'] ?? '';
    $html .= "
            <div x-data=\"{ open: false }\" class=\"p-4\">
                <button class=\"w-full text-left font-semibold\" @click=\"open = !open\">
                    $title
                </button>
                <div x-show=\"open\" x-transition class=\"mt-2 text-gray-600\">
                    $content
                </div>
            </div>
        ";
}

echo "
<div class=\"$class\" $extras>
    $html
</div>
    ";
// };
