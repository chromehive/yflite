<?php
// return function ($props) {
$base = require __DIR__ . '/_base.php';
[$slot, $class, $extras] = $base($props, [
    'name',
    'value',
    'placeholder',
    'height',
    'mode',
    'action',
    'actionLabel'
]);

$id = uniqid('rte_');
$name        = ($props['name'] ?? 'content') . "_$id";
$value       = $props['value'] ?? '';
$placeholder = $props['placeholder'] ?? 'Write something…';
$height      = $props['height'] ?? '250px';
$mode        = $props['mode'] ?? 'wysiwyg'; // wysiwyg | markdown
$action      = $props['action'] ?? '';
$actionLabel = $props['actionLabel'] ?? '';
// $slot = $slot ?: $placeholder;

$class = $class ?: "border rounded bg-white";

if (isset($slot) && !empty($slot) && !empty($value)) {
    $initialValue = trim($slot) . '<br>' . trim($value);
} elseif (isset($slot) && empty($value)) {
    $initialValue = trim($slot);
} else {
    $initialValue = trim($value);
}

// Escape textarea value
$escaped = htmlspecialchars($initialValue);

?>
<!-- RTE START -->
<div
    x-data="richEditor({
        initial: `<?= $escaped ?>`,
        mode: '<?= $mode ?>'
    })"
    class="<?= $class ?>"
    id="<?= $id ?>"
    <?= $extras ?>>

    <!-- Toolbar -->
    <div class="flex items-center gap-2 p-2 border-b bg-gray-50 text-sm">

        <!-- Bold -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded"
            @click="toggleBold()"><strong>B</strong></button>

        <!-- Italic -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded italic"
            @click="toggleItalic()">I</button>

        <!-- H1 -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded"
            @click="heading(1)">H1</button>

        <!-- H2 -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded"
            @click="heading(2)">H2</button>

        <!-- Bullet list -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded"
            @click="bulletList()">• List</button>

        <!-- Code -->
        <button type="button" class="px-2 py-1 hover:bg-gray-100 rounded font-mono"
            @click="inlineCode()">{ }</button>

        <!-- Mode Switch &rarr; Markdown Incomplete -->
        <button
            type="button"
            class="ml-auto px-2 py-1 border rounded text-xs bg-white hover:bg-gray-100"
            @click="toggleMode()"
            x-text="mode === 'wysiwyg' ? 'See HTML' : 'See WYSIWYG'">
        </button>

    </div>


    <!-- Editable Area -->
    <div
        x-show="mode === 'wysiwyg'"
        x-ref="wysiwyg"
        contenteditable="true"
        class="p-3 prose max-w-none focus:outline-none"
        style="min-height: <?= $height ?>"
        @input="sync()"
        placeholder="<?= $placeholder ?>"></div>

    <!-- Markdown Mode -->
    <textarea
        x-show="mode === 'markdown'"
        x-ref="markdown"
        class="w-full p-3 font-mono text-sm border-t focus:outline-none"
        style="min-height: <?= $height ?>"
        @input="sync()"
        placeholder="<?= $placeholder ?>"></textarea>


    <!-- Hidden field for forms -->
    <input type="hidden" name="<?= $name ?>" x-ref="hidden" />

    <!-- <button hx-post=< ?= $action ?> hx-include="[name='< ?= $name ?>']">< ?= $actionLabel ?></button> -->
    <?= !empty($action) && !empty($actionLabel) ? yui("button", ['hx-post' => $action, 'slot' => $actionLabel, 'hx-include' => "[name='$name']"]) : ''; ?>
</div>

<script>
    document.addEventListener('alpine:init', () => {

        Alpine.data('richEditor', (config) => ({

            mode: config.mode,
            initial: config.initial,

            init() {
                // Load initial content
                if (this.mode === 'wysiwyg') {
                    this.$refs.wysiwyg.innerHTML = this.initial;
                } else {
                    this.$refs.markdown.value = this.initial;
                }
                this.sync();
            },

            sync() {
                // Sync content to hidden field
                if (this.mode === 'wysiwyg') {
                    this.$refs.hidden.value = this.$refs.wysiwyg.innerHTML;
                } else {
                    this.$refs.hidden.value = this.$refs.markdown.value;
                }
            },

            toggleMode() {
                this.mode = this.mode === 'wysiwyg' ? 'markdown' : 'wysiwyg';

                if (this.mode === 'markdown') {
                    this.$refs.markdown.value = this.$refs.wysiwyg.innerHTML;
                } else {
                    this.$refs.wysiwyg.innerHTML = this.$refs.markdown.value;
                }
                this.sync();
            },

            // ---- Formatting Commands ----

            format(cmd, value = null) {
                document.execCommand(cmd, false, value);
                this.sync();
            },

            toggleBold() {
                this.format('bold');
            },
            toggleItalic() {
                this.format('italic');
            },

            heading(level) {
                this.format('formatBlock', 'H' + level);
            },

            bulletList() {
                this.format('insertUnorderedList');
            },

            inlineCode() {
                this.format('insertHTML', '<code>' + document.getSelection() + '</code>');
            }

        }));

    });
</script>
<!-- RTE END -->