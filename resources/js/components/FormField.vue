<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <froala
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
    },

    data() {
        return {
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
            return {
                // Set max image size to 5MB.
                imageMaxSize: 5 * 1024 * 1024,

                // Allow to upload PNG and JPG.
                imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],

                // Set max file size to 20MB.
                fileMaxSize: 20 * 1024 * 1024,

                // Allow to upload any file.
                fileAllowedTypes: ['*'],

                ...this.mediaConfigurator.getConfig(),
            };
        },
    },
};
</script>
