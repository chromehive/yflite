<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['format']);

$format = $props['format'] ?? 'HH:mm:ss';

$class = $class ?: 'font-mono text-lg';

echo "
        <div
            x-data=\"{
                time: '',
                fmt: '$format',
                update(){
                    const d = new Date();
                    let h = d.getHours().toString().padStart(2,'0');
                    let m = d.getMinutes().toString().padStart(2,'0');
                    let s = d.getSeconds().toString().padStart(2,'0');

                    this.time = this.fmt
                        .replace('HH', h)
                        .replace('mm', m)
                        .replace('ss', s)
                }
            }\"
            x-init=\"update(); setInterval(() => update(), 1000)\"
            class=\"$class\"
            $extras
        >
            <span x-text=\"time\"></span>
        </div>
    ";
// };