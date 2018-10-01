<template>
    <panel-item :field="field">
        <template slot="value">
            <excerpt>
                <froalaView v-model="field.value"></froalaView>
            </excerpt>
        </template>
    </panel-item>
</template>

<script>
    import Excerpt from './Excerpt';

    export default {
        props: ['resource', 'resourceName', 'resourceId', 'field'],

        components: { Excerpt },
    };
</script>
