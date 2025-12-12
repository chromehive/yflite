<?php
// return function($props){
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['icon', 'active']);

$icon   = $props['icon'] ?? null;
// $active = $props['active'];
// var_dump($props);
// exit(0);
if (isset($props['active'])) {
    $active = "data-active='$active'";
} else {
    $active = "data-active='false'";
}

$class = $class ?: '
        flex flex-col items-center text-xs
        text-gray-600 data-[active=true]:text-blue-600
    ';

// echo "
?>
<button class="<?= $class ?>" <?= $active ?> <?= $extras ?>>
    <span class="material-icons"><?= $icon ?></span>
    <span><?= $slot ?></span>
</button>
<!-- ";
// }; -->