<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title', 'subtitle', 'avatar', 'icon']);

$title   = $props['title'] ?? '';
$subtitle = $props['subtitle'] ?? '';
$avatar  = $props['avatar'] ?? null; // image or initials
$icon    = $props['icon'] ?? null;
$class   = $props['class'] ?? 'flex items-center gap-3 p-3 border-b';

if ($slot) {
    return "<div class=\"$class\" $extras>$slot</div>";
}

$left = '';
if ($avatar) {
    // developer uses our <x-ui.avatar>
    $left = yui('ui.avatar', ['src' => $avatar, 'size' => 10]);
} elseif ($icon) {
    $left = "<div class=\"text-xl\">$icon</div>";
}

echo "
        <div class=\"$class\" $extras>
            $left
            <div class=\"flex flex-col\">
                <span class=\"font-medium\">$title</span>
                <span class=\"text-xs text-gray-500\">$subtitle</span>
            </div>
        </div>
    ";
// };
