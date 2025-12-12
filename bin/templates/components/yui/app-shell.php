<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['sidebar', 'navbar']);

$sidebar = $props['sidebar'] ?? '';
$navbar  = $props['navbar'] ?? '';

$class = $class ?: "min-h-screen flex flex-col";

echo "
        <div class=\"$class\" $extras>
            <div class=\"border-b\">
                $navbar
            </div>
            <div class=\"flex flex-1\">
                <aside class=\"border-r w-64\">
                    $sidebar
                </aside>
                <main class=\"flex-1 p-6\">
                    $slot
                </main>
            </div>
        </div>
    ";
// };
