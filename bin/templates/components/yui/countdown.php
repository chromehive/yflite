<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['until']);

$until = $props['until'] ?? null; // timestamp or datetime string

if (!$until) {
    echo "<div class='text-red-500'>Countdown requires 'until' prop</div>";
}

$class = $class ?: 'font-mono text-lg';

echo "
        <div
            x-data=\"{
                end: new Date('$until').getTime(),
                now: Date.now(),
                left: 0,
                tick(){
                    this.now = Date.now();
                    this.left = Math.max(0, this.end - this.now);
                }
            }\"
            x-init=\"setInterval(() => tick(), 1000)\"
            class=\"$class\"
            $extras
        >
            <span x-text=\"Math.floor(left/1000/60/60).toString().padStart(2,'0')\"></span>:
            <span x-text=\"Math.floor(left/1000/60 % 60).toString().padStart(2,'0')\"></span>:
            <span x-text=\"Math.floor(left/1000 % 60).toString().padStart(2,'0')\"></span>
        </div>
    ";
// };