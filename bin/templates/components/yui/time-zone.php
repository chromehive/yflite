<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['tz', 'format']);

$tz     = $props['tz']     ?? 'UTC';
$format = $props['format'] ?? 'HH:mm:ss';

$class = $class ?: 'font-mono text-lg';

echo "
        <div
            x-data=\"{
                now: '',
                tz: '$tz',
                fmt: '$format',
                update(){
                    const d = new Date();
                    const opt = { timeZone: this.tz, hour12: false,
                                  hour: '2-digit', minute: '2-digit', second: '2-digit' };
                    const parts = new Intl.DateTimeFormat('en-US', opt).formatToParts(d);

                    let h = parts.find(p => p.type === 'hour').value;
                    let m = parts.find(p => p.type === 'minute').value;
                    let s = parts.find(p => p.type === 'second').value;

                    this.now = this.fmt
                        .replace('HH', h)
                        .replace('mm', m)
                        .replace('ss', s);
                }
            }\"
            x-init=\"update(); setInterval(() => update(), 1000)\"
            class=\"$class\"
            $extras
        >
            <span x-text=\"now\"></span>
        </div>
    ";
// };