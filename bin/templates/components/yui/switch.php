<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'name',
    'label',
    'checked'
]);

$name    = $props['name'] ?? '';
$label   = $props['label'] ?? null;
$checked = isset($props['checked']) ? 'true' : 'false';

$content = $slot ?: $label;

echo "
        <label class=\"flex items-center space-x-3 cursor-pointer\">
            <div x-data=\"{ on: $checked }\">
                <input type=\"hidden\" name=\"$name\" :value=\"on ? '1' : '0'\">
                <div
                    class=\"relative w-10 h-5 bg-gray-300 rounded-full transition\"
                    :class=\"on ? 'bg-blue-600' : 'bg-gray-300'\"
                    @click=\"on = !on\"
                >
                    <div
                        class=\"absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-white transition-transform transform\"
                        :class=\"on ? 'translate-x-5' : ''\"
                    ></div>
                </div>
            </div>
            <span class=\"text-gray-700\">$content</span>
        </label>
    ";
// };
