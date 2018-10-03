<template>
    <field-wrapper>
        <div class="w-1/5 px-8 py-6">
            <slot>
                <form-label :for="field.name" :class="{
                    'mb-2': field.helpText && showHelpText
                }">
                    {{ fieldLabel }}
                </form-label>

                <help-text :show-help-text="showHelpText">
                    {{ field.helpText }}
                </help-text>
            </slot>
        </div>
        <div class="w-4/5 px-8 py-6">
            <froala
                :id="field.name"
                :tag="'textarea'"
                :config="options"
                :placeholder="field.name"
                v-model="value"
            ></froala>

            <p v-if="hasError" class="my-2 text-danger">
                {{ firstError }}
            </p>
        </div>
    </field-wrapper>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

import MediaConfigurator from '../MediaConfigurator';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

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
        fieldLabel() {
            // If the field name is purposefully an empty string, then
            // let's show it as such
            if (this.fieldName === '') {
                return '';
            }

            return this.fieldName || this.field.singularLabel || this.field.name;
        },
    },

    methods: {
        /*
             * Set the initial, internal value for the field.
             */
        setInitialValue() {
            this.value = this.field.value || '';
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '');
            formData.append(this.field.attribute + 'DraftId', this.field.draftId);
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value;
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
