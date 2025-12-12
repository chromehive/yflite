<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['speed']);

$speed = $props['speed'] ?? '20s'; // animation duration

$class = $class ?: 'overflow-hidden whitespace-nowrap relative';

echo "
        <div
            x-data=\"{ paused: false }\"
            @mouseenter=\"paused = true\"
            @mouseleave=\"paused = false\"
            class=\"$class\"
            $extras
        >
            <div
                :class=\"paused ? 'animate-none' : 'animate-marquee'\"
                style=\"animation-duration: $speed;\"
                class=\"inline-block whitespace-nowrap\"
            >
                $slot
            </div>
        </div>

        <style>
            @keyframes marquee {
                0%   { transform: translateX(100%); }
                100% { transform: translateX(-100%); }
            }
            .animate-marquee {
                animation: marquee linear infinite;
            }
        </style>
    ";
// };