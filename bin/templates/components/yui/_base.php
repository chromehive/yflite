<?php

/**
 * YUI Base Helper to reduce repeated logic.
 *
 * @param array $props - raw props passed to component.
 * @param array $exclude - props or attributes that should NOT be forwarded to parent frontend (component-specific).
 *
 * @return array [$slot, $class, $extras]
 * $props = []
 */
return function (array $props = [], array $exclude = []) {
    $slot  = $props['slot'] ?? '';
    $class = $props['class'] ?? '';

    // Always exclude these common props
    $exclude = array_merge($exclude, ['slot', 'class']);

    // Forward extras
    $extras = '';
    foreach ($props as $k => $v) {
        if (!in_array($k, $exclude)) {
            $extras .= "$k=\"$v\" ";
        }
    }

    return [$slot, $class, $extras];
};
