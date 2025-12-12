<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['mine', 'avatar', 'name', 'time', 'message']);

$mine      = isset($props['mine']) && $props['mine'] === 'true';
$avatar    = $props['avatar'] ?? null;
$name      = $props['name'] ?? '';
$time      = $props['time'] ?? '';
$message   = $props['message'] ?? '';
$class     = $props['class'] ?? '';

$wrapperAlign = $mine ? "justify-end" : "justify-start";
$bubbleAlign  = $mine ? "bg-blue-600 text-white" : "bg-gray-100 dark:bg-gray-800";
$avatarHtml   = '';

if (!$mine && $avatar) {
    $avatarHtml = yui('ui.avatar', ['src' => $avatar, 'size' => 8]);
}

$content = $slot ?: "
        <div class=\"text-sm mb-1 font-medium\">$name</div>
        <div class=\"text-sm\">$message</div>
        <div class=\"text-xs opacity-70 mt-1\">$time</div>
    ";

echo "
        <div class=\"flex $wrapperAlign my-2\" $extras>
            <div class=\"flex gap-2 max-w-xs\">
                $avatarHtml
                <div class=\"p-3 rounded-xl $bubbleAlign $class\">$content</div>
            </div>
        </div>
    ";
// };
