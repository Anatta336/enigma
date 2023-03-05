<template>
    <vue-multiselect
        v-model="selectedIndex"
        :options="indexOptions"
        :multiple="false"
        placeholder="Select Index"
        :searchable="false"
        :allow-empty="false"
        :showLabels="false"
    />
</template>

<script>
import VueMultiselect from 'vue-multiselect';

export default {
    components: {
        VueMultiselect,
    },

    props: {
        modelValue: {
            type: Number,
            required: true,
        },
        indexOptions: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            internalValue: 0,
        };
    },

    computed: {
        selectedIndex: {
            get() {
                return this.internalValue;
            },
            set(value) {
                this.internalValue = value;
                this.$emit('update:modelValue', this.internalValue);
            },
        },
    },
}
</script>