<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['title']);

$title = $props['title'] ?? 'Schedule';

$class = $class ?: 'border rounded-lg bg-white shadow-sm';

echo "
        <div class=\"$class p-4\" $extras>
            <h2 class='font-bold mb-3'>$title</h2>

            <div class='grid grid-cols-[120px_1fr] text-sm'>
                <div class='space-y-4'>
                    " . implode('', array_map(fn($h) => "
                        <div class='pt-2 text-gray-600'>$h:00</div>
                    ", range(6, 20))) . "
                </div>

                <div class='relative border-l pl-4'>
                    <div class='absolute left-0 right-0 border-t'
                         style='top: 120px'></div>

                    <div class='absolute bg-blue-600 text-white px-3 py-1 rounded shadow
                                w-48'
                         style='top:180px; left:20px;'>
                        Event: Team Meeting
                    </div>

                    <div class='absolute bg-green-600 text-white px-3 py-1 rounded shadow
                                w-48'
                         style='top:320px; left:120px;'>
                        Event: Presentation
                    </div>

                    $slot
                </div>
            </div>
        </div>
    ";
// };
