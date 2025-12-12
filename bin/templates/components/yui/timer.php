<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['start']);

$start = $props['start'] ?? 0; // seconds

$class = $class ?: 'font-mono text-lg';

echo "
        <div
            x-data=\"{
                t: $start,
                tick(){
                    this.t++;
                }
            }\"
            x-init=\"setInterval(() => tick(), 1000)\"
            class=\"$class\"
            $extras
        >
            <span x-text=\"Math.floor(t/3600).toString().padStart(2,'0')\"></span>:
            <span x-text=\"Math.floor(t/60 % 60).toString().padStart(2,'0')\"></span>:
            <span x-text=\"(t % 60).toString().padStart(2,'0')\"></span>
        </div>
    ";
// };