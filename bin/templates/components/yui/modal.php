<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['open', 'trigger']);

$open = $props['open'] ?? 'false';
$class = $class ?: 'bg-white rounded-lg shadow-xl w-full max-w-lg';

?>
<div x-data="{ open: <?= $open ?> }" <?= $extras ?>>

    <!-- Trigger -->
    <div @click="open = true">
        <?= $props['trigger'] ?? ''; ?>
    </div>

    <!-- Overlay -->
    <div
        x-show="open"
        class="fixed inset-0 bg-black/50 flex items-center justify-center p-4"
        @click.self="open = false"
        x-transition.opacity>

        <!-- Modal -->
        <div
            class="<?= $class ?> p-6 relative"
            x-transition>
            <?= $slot ?>

            <button
                class="absolute top-2 right-2 text-gray-500"
                @click="open = false">&times;</button>
        </div>

    </div>

</div>