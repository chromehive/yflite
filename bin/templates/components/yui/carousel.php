<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['height']);

$height = $props['height'] ?? "200px";

$class = $class ?: "relative overflow-hidden rounded-lg";

// echo "
?>
<div x-data="{ index:0, total:0 }" x-init="total = $refs.slides.children.length" class="<?= $class ?>" style="height:<?= $height ?>" <?= $extras ?>>

    <div class="absolute inset-0 flex" x-ref="slides" :style="`transform: translateX(-${index * 100}%); transition: 0.4s`">
        $slot
    </div>

    <button
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 rounded-full px-3 py-1 shadow"
        @click="index = (index - 1 + total) % total">‹</button>

    <button
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 rounded-full px-3 py-1 shadow"
        @click="index = (index + 1) % total">›</button>
</div>
<!-- ";
// }; -->