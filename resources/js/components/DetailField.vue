<template>
    <panel-item :field="field">
        <template slot="value">
            <div v-if="field.shouldShow && hasContent">
                <div class="markdown leading-normal">
                    <froalaView v-model="field.value"></froalaView>
                </div>
            </div>
            <div v-else-if="hasContent">
                <div v-if="expanded" class="markdown leading-normal">
                    <froalaView v-model="field.value"></froalaView>
                </div>

                <a
                    v-if="!field.shouldShow"
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
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

    data: () => ({ expanded: false }),

    methods: {
        toggle() {
            this.expanded = !this.expanded
        },
    },

    computed: {
        hasContent() {
            return this.content !== '' && this.content !== null
        },

        showHideLabel() {
            return !this.expanded ? this.__('Show Content') : this.__('Hide Content')
        },
    },
};
</script>
