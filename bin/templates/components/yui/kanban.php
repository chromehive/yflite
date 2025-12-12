<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['columns']);

$columns = $props['columns'] ?? [];
$class   = $props['class'] ?? 'grid grid-cols-1 md:grid-cols-3 gap-4';

if ($slot) {
    echo "<div class=\"$class\" $extras>$slot</div>";
    return;
}

$html = "<div class=\"$class\" $extras>";

foreach ($columns as $column) {
    $title = $column['title'] ?? 'Untitled';
    $items = $column['items'] ?? [];

    $html .= "
            <div class=\"p-3 border rounded bg-gray-50 dark:bg-gray-800\">
                <h3 class=\"font-semibold mb-3\">$title</h3>
                <div class=\"flex flex-col gap-2\">
        ";

    foreach ($items as $item) {
        $cardTitle = $item['title'] ?? '';
        $cardDesc  = $item['description'] ?? '';

        $html .= "
                <div class=\"p-3 bg-white dark:bg-gray-700 border rounded shadow-sm\">
                    <div class=\"font-medium\">$cardTitle</div>
                    <div class=\"text-xs text-gray-500\">$cardDesc</div>
                </div>
            ";
    }

    $html .= "
                </div>
            </div>
        ";
}

$html .= "</div>";

echo $html;
// };
