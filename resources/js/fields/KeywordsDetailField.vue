<template>
    <panel-item :field="field">
        <span slot="value" v-html="field.value.join(', ') || '—'"></span>
    </panel-item>
</template>

<script>
export default {
    inheritAttrs: false,

    props: ['field'],
};
</script>
