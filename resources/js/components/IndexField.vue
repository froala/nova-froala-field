<template>
    <div>
        <a
            @click="toggle"
            class="cursor-pointer dim inline-block text-primary font-bold"
            aria-role="button"
        >
            {{ showHideLabel }}
        </a>
        <transition name="fade">
            <modal v-if="expanded" @modal-close="toggle">
                <div class="fr-view-modal bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="fr-view-modal__content p-8">
                        <froalaView v-model="field.value"></froalaView>
                    </div>
                    <div class="bg-30 px-6 py-3 flex">
                        <div class="ml-auto">
                            <button type="button" data-testid="cancel-button" @click.prevent="toggle" class="btn text-80 font-normal h-9 px-3 mr-3 btn-link">{{__('Close')}}</button>
                        </div>
                    </div>
                </div>
            </modal>
        </transition>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    data: () => ({ expanded: false }),

    computed: {
        showHideLabel() {
            return !this.expanded ? this.__('Show Content') : this.__('Hide Content');
        },
    },

    methods: {
        toggle() {
            this.expanded = !this.expanded;
        },
    },
};
</script>
