<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['name', 'size', 'modified', 'icon', 'view', 'href']);

$name     = $props['name'] ?? '';
$size     = $props['size'] ?? '';
$modified = $props['modified'] ?? '';
$icon     = $props['icon'] ?? '📄';
$view     = $props['view'] ?? 'grid'; // grid or list
$href     = $props['href'] ?? '#';
$class    = $props['class'] ?? '';

if ($slot) {
    return "<a href=\"$href\" class=\"$class\" $extras>$slot</a>";
}

if ($view === 'list') {
    return "
            <a href=\"$href\" class=\"flex items-center gap-3 p-2 border-b hover:bg-gray-100 dark:hover:bg-gray-800 $class\" $extras>
                <span class=\"text-2xl\">$icon</span>
                <div class=\"flex-1\">
                    <div class=\"font-medium\">$name</div>
                    <div class=\"text-xs text-gray-500\">$modified · $size</div>
                </div>
            </a>
        ";
}

echo "
        <a href=\"$href\" class=\"flex flex-col items-center p-3 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 $class\" $extras>
            <span class=\"text-4xl mb-2\">$icon</span>
            <span class=\"font-medium truncate w-full text-center\">$name</span>
            <span class=\"text-xs text-gray-500\">$size</span>
        </a>
    ";
// };
