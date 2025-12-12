<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['tabs', 'active']);

$tabs   = $props['tabs'] ?? [];
$active = $props['active'] ?? null;

$class = $class ?: 'flex gap-4';

$list = "";
foreach ($tabs as $key => $label) {
    $isActive = ($key === $active) ? 'font-semibold text-blue-600' : 'text-gray-700';
    $list .= "
            <button class=\"$isActive\" hx-get=\"?tab=$key\">
                $label
            </button>
        ";
}

echo "
        <div class=\"$class\" $extras>
            <div class=\"flex flex-col gap-2 w-40\">
                $list
            </div>
            <div class=\"flex-1\">
                $slot
            </div>
        </div>
    ";
// };
