<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['sender', 'subject', 'excerpt', 'unread', 'time']);

$sender  = $props['sender'] ?? 'Unknown';
$subject = $props['subject'] ?? '(No Subject)';
$excerpt = $props['excerpt'] ?? '';
$unread  = ($props['unread'] ?? false) === 'true';
$time    = $props['time'] ?? '';
$class   = $props['class'] ?? '';

$unreadClass = $unread ? 'font-semibold' : 'text-gray-600';

echo "
        <div class=\"flex items-start gap-3 p-3 border-b hover:bg-gray-50 cursor-pointer $class\">
            <div class=\"flex flex-col flex-1\">
                <span class=\"$unreadClass\">$sender</span>
                <span class=\"text-sm text-gray-800\">$subject</span>
                <span class=\"text-xs text-gray-500\">$excerpt</span>
            </div>
            <span class=\"text-xs text-gray-400 whitespace-nowrap\">$time</span>
        </div>
    ";
// };
