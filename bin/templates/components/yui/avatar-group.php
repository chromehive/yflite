<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['max', 'avatars']);

$avatars = $props['avatars'] ?? [];   // array of avatars: [['src'=>..., 'initials'=>...], ...]
$max     = $props['max'] ?? 5;

$class = $class ?: 'flex -space-x-3';

$count = count($avatars);
$visible = array_slice($avatars, 0, $max);
$remaining = $count - $max;

$html = "<div class=\"$class\" $extras>";
// var_dump($avatars);
// exit;
foreach ($visible as $a) {
    $src = $a['src'] ?? null;
    $initials = $a['initials'] ?? null;

    if ($src) {
        $html .= "<img src=\"$src\" class=\"w-10 h-10 rounded-full border-2 border-white object-cover\" />";
    } else {
        $html .= "<div class=\"w-10 h-10 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-sm font-medium text-gray-700\">$initials</div>";
    }
}

if ($remaining > 0) {
    $html .= "
            <div class=\"w-10 h-10 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center text-xs font-semibold text-gray-700\">
                +$remaining
            </div>
        ";
}

echo $html . "</div>";
// };
