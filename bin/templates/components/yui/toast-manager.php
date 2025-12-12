<?php
// return function ($props) {
echo "
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('toasts', {
        list: [],
        push(msg, timeout = 3000) {
            const id = Date.now();
            this.list.push({ id, msg });

            setTimeout(() => {
                this.list = this.list.filter(t => t.id !== id);
            }, timeout);
        }
    });
});
</script>

<div class=\"fixed bottom-4 right-4 space-y-2 z-50\">
    <template x-for=\"t in \$store.toasts.list\" :key=\"t.id\">
        <div
            x-text=\"t.msg\"
            x-transition
            class=\"bg-gray-900 text-white px-4 py-2 rounded shadow\"
        ></div>
    </template>
</div>
    ";
// };
