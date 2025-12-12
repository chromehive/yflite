<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'message', 'icon', 'action']);

$title = $props['title'] ?? '';
$message = $props['message'] ?? '';
$icon = $props['icon'] ?? '📢';
$action = $props['action'] ?? null; // ['label'=>'Subscribe','href'=>'/newsletter']
$class = $props['class'] ?? 'p-4 rounded-lg border bg-yellow-50 dark:bg-yellow-900/30';

if ($slot) {
    return "<div class=\"$class\" $extras>$slot</div>";
}

$button = '';
if ($action) {
    $button = "<a href=\"{$action['href']}\" class=\"px-3 py-1 text-sm rounded bg-yellow-600 text-white\">{$action['label']}</a>";
}

echo "
        <div x-data=\"{show:true}\" x-show=\"show\" $extras class=\"$class\">
            <div class=\"flex items-start gap-3\">
                <div class=\"text-2xl\">$icon</div>
                <div class=\"flex-1\">
                    <div class=\"font-semibold\">$title</div>
                    <p class=\"text-sm mt-1\">$message</p>
                </div>
                <div class=\"flex items-center gap-2\">
                    $button
                    <button @click=\"show=false\" class=\"text-xl leading-none\">×</button>
                </div>
            </div>
        </div>
    ";
// };
