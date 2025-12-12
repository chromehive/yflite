<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['tabs']);

$tabs = $props['tabs'] ?? [];
$class = $class ?: '';
$id = uniqid('tabs_');

$nav = '';
$panels = '';

foreach ($tabs as $i => $t) {
    $label = $t['label'] ?? "Tab " . ($i + 1);
    $content = $t['content'] ?? '';
    $active = $i === 0 ? 'true' : 'false';

    $nav .= "
            <button
                class=\"px-4 py-2 border-b-2\"
                :class=\"active === $i ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500'\"
                @click=\"active = $i\"
            >
                $label
            </button>
        ";

    $panels .= "
            <div x-show=\"active === $i\" class=\"p-4\">
                $content
            </div>
        ";
}

echo "
<div x-data=\"{ active: 0 }\" class=\"w-full $class\" $extras>
    <div class=\"flex gap-2 border-b\">$nav</div>
    <div>$panels</div>
</div>
    ";
// };
