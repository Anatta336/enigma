<template>
    <div>
        <vue-multiselect
            v-model="selectedRotor"
            :options="filteredOptions"
            label="name"
            track-by="name"
            :multiple="false"
            placeholder="Select Rotor"
            :searchable="false"
            :allow-empty="false"
            :showLabels="false"
        />
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect';

export default {
    components: {
        VueMultiselect,
    },

    props: {
        modelValue: {
            type: Object,
            required: true,
        },
        allRotors: {
            type: Array,
            required: true,
        },
        otherRotors: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            internalValue: {},
        };
    },

    computed: {
        selectedRotor: {
            get() {
                return this.internalValue;
            },
            set(value) {
                this.internalValue = value;
                this.$emit('update:modelValue', this.internalValue);
            },
        },
        filteredOptions: {
            get() {
                return this.allRotors.map((item) => {
                    const isInUse = !!this.otherRotors.find(rotor => rotor.name == item.name);

                    return {
                        $isDisabled: isInUse,
                        ...item,
                    };
                });
            }
        },
    },
}
</script>
