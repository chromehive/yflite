<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['items']);

$items = $props['items'] ?? [];
$class = $class ?: "flex flex-col gap-1";

$render = function ($items) use (&$render) {
    $html = "";
    foreach ($items as $label => $children) {
        if (is_array($children)) {
            $sub = $render($children);
            $html .= "
                    <div class='pl-2'>
                        <div class='font-semibold'>$label</div>
                        <div class='ml-3 border-l pl-2 space-y-1'>
                            $sub
                        </div>
                    </div>
                ";
        } else {
            $html .= "<a href=\"$children\" class=\"block text-gray-700\">$label</a>";
        }
    }
    return $html;
};

echo "
        <nav class=\"$class\" $extras>
            " . $render($items) . "
            $slot
        </nav>
    ";
// };
