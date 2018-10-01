<template>
    <div v-if="hasContent">
        <slot v-if="expanded" class="markdown leading-normal" />

        <a
            @click="toggle"
            class="cursor-pointer dim inline-block text-primary font-bold"
            :class="{ 'mt-6': expanded }"
            aria-role="button"
        >
            {{ showHideLabel }}
        </a>
    </div>
    <div v-else>
        &mdash;
    </div>
</template>

<script>
export default {
    data: () => ({ expanded: false }),

    methods: {
        toggle() {
            this.expanded = !this.expanded;
        },
    },

    computed: {
        hasContent() {
            return this.content !== '' && this.content !== null;
        },
        showHideLabel() {
            return !this.expanded ? 'Show Content' : 'Hide Content';
        },
    },
};
</script>
