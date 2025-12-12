<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, ['name', 'tags', 'placeholder']);

$name        = $props['name'] ?? 'tags';
$placeholder = $props['placeholder'] ?? 'Add tag…';
$tags        = $props['tags'] ?? []; // array of strings
$id          = uniqid('taginput_');

$class = $class ?: "flex flex-wrap gap-2 p-2 border rounded bg-white";

// Render existing tags
$renderedTags = '';
foreach ($tags as $tag) {
    $t = htmlspecialchars($tag);
    $renderedTags .= "
            <span
                class=\"px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded flex items-center gap-1\"
                x-data
            >
                $t
                <button
                    type=\"button\"
                    class=\"text-blue-700 hover:text-blue-900\"
                    @click=\"\$el.parentElement.remove(); renewHidden()\"
                >&times;</button>
            </span>
        ";
}

?>
<div
    x-data="{
                renewHidden(){
                    let list = [...$el.querySelectorAll('[data-tag]')].map(t => t.dataset.tag);
                    $el.querySelector('input[type=hidden]').value = list.join(',');
                }
            }"
    class="<?= $class ?>"
    <?= $extras ?>>

    <?= $renderedTags ?>

    <input
        type="text"
        class="flex-1 p-1 outline-none text-sm"
        placeholder="<?= $placeholder ?>"
        @keydown.enter.prevent="
                    if($el.value.trim() !== ''){
                        let val = $el.value.trim();
                        $el.insertAdjacentHTML('beforebegin', `
                            <span data-tag=${val}
                                  class='px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded flex items-center gap-1'>
                                ${val}
                                <button type='button' class='text-blue-700 hover:text-blue-900'
                                    @click='$el.parentElement.remove(); renewHidden()'>
                                    &times;
                                </button>
                            </span>
                        `);
                        $el.value = '';
                        renewHidden();
                    }
                ">

    <input type="hidden" name="$name" value="<?= implode(',', $tags);  ?>" />
</div>