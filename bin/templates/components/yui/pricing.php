<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['billing']);

$billing = $props['billing'] ?? 'monthly';

$class = $class ?: 'grid md:grid-cols-3 gap-6';

$plans = [
    "Personal" => [
        "monthly" => "$9",
        "yearly"  => "$90"
    ],
    "Business" => [
        "monthly" => "$29",
        "yearly"  => "$290"
    ],
    "Enterprise" => [
        "monthly" => "$99",
        "yearly"  => "$990"
    ]
];

$html = "<div class=\"$class\" $extras>";

foreach ($plans as $name => $price) {
    $p = $price[$billing];

    $html .= "
            <div class='border rounded-lg p-6 shadow-sm bg-white'>
                <h3 class='text-xl font-semibold mb-1'>$name</h3>
                <p class='text-3xl font-bold mb-4'>$p</p>
                <ul class='space-y-1 text-sm mb-4 text-gray-600'>
                    <li>✔ Feature 1</li>
                    <li>✔ Feature 2</li>
                    <li>✔ Feature 3</li>
                </ul>
                <a href='#' class='block bg-blue-600 text-white text-center py-2 rounded-md'>
                    Choose Plan
                </a>
            </div>
        ";
}

$html .= "</div>";

echo $html;
// };
