<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['headers', 'rows']);

$headers = $props['headers'] ?? [];
$rows    = $props['rows'] ?? [];
$class   = $props['class'] ?? 'w-full border border-gray-200 text-left';
$extras  = $props['extras'] ?? '';

$thead = '';
foreach ($headers as $h) {
    $thead .= "<th class=\"px-3 py-2 border-b font-semibold bg-gray-50\">$h</th>";
}

$tbody = '';
foreach ($rows as $row) {
    $tbody .= "<tr>";
    foreach ($row as $cell) {
        $tbody .= "<td class=\"px-3 py-2 border-b\">$cell</td>";
    }
    $tbody .= "</tr>";
}

echo "
        <table class=\"$class\" $extras>
            <thead><tr>$thead</tr></thead>
            <tbody>$tbody</tbody>
        </table>
    ";
// };
