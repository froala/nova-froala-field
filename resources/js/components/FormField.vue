<template>
    <default-field @keydown.native.stop :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <froala
                v-if="!loading"
                :id="field.name"
                :tag="'textarea'"
                :config="options"
                :placeholder="field.name"
                v-model="value"
            ></froala>
        </template>
    </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

import MediaConfigurator from '../MediaConfigurator';
import PluginsLoader from '../PluginsLoader';

export default {
    mixins: [HandlesValidationErrors, FormField],

    beforeDestroy() {
        this.mediaConfigurator.cleanUp();
    },

    mounted() {
        if (typeof window.froala !== 'undefined' && typeof window.froala.events !== 'undefined') {
            _.forEach(window.froala.events, value => {
                value.apply(this);
            });
        }

        new PluginsLoader(this.options, this.$toasted).registerPlugins().then((data) => {
            this.loading = false;
        })
    },

    data() {
        return {
            loading: true,
            mediaConfigurator: new MediaConfigurator(this.resourceName, this.field, this.$toasted),
        };
    },

    computed: {
        options() {
            return _.merge(this.field.options, this.defaultConfig(), window.froala || {});
        },
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
            formData.append(this.field.attribute + 'DraftId', this.field.draftId);
        },

        /**
         * Additional configurations
         */
        defaultConfig() {
            return this.mediaConfigurator.getConfig();
        },
    },
};
</script>
