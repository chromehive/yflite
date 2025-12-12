<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props);

$class = $class ?: 'fixed bottom-8 right-8 flex flex-col items-end space-y-3';

echo "
        <div x-data=\"{ open: false }\" class=\"$class\" $extras>
            <div x-show=\"open\" x-transition.origin.bottom>
                $slot
            </div>

            <button
                @click=\"open = !open\"
                class=\"w-14 h-14 flex items-center justify-center rounded-full shadow-lg bg-blue-600 text-white\">
                <span x-show=\"!open\" class=\"material-icons\">add</span>
                <span x-show=\"open\" class=\"material-icons\">close</span>
            </button>
        </div>
    ";
// };