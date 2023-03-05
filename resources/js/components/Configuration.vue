<template>
    <div class="rotor-row">
        <div class="rotor-wrap">
            <label>Left Rotor</label>
            <vue-multiselect
                v-model="leftRotor"
                :options="leftOptions"
                label="name"
                track-by="name"
                :multiple="false"
                placeholder="Select Rotor"
                :searchable="false"
                :allow-empty="false"
                :showLabels="false"
            />
        </div>
        <div class="rotor-wrap">
            <label>Middle Rotor</label>
            <vue-multiselect
                v-model="middleRotor"
                :options="middleOptions"
                label="name"
                track-by="name"
                :multiple="false"
                placeholder="Select Rotor"
                :searchable="false"
                :allow-empty="false"
                :showLabels="false"
            />
        </div>
        <div class="rotor-wrap">
            <label>Right Rotor</label>
            <vue-multiselect
                v-model="rightRotor"
                :options="rightOptions"
                label="name"
                track-by="name"
                :multiple="false"
                placeholder="Select Rotor"
                :searchable="false"
                :allow-empty="false"
                :showLabels="false"
            />
        </div>
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
    },

    data() {
        return {
            internalConfig: {},
            nameOptions: [],

            // @TODO is this going to be used?
            fullOptions: [],
        };
    },

    computed: {
        leftRotor: {
            get() {
                return this.internalConfig.leftRotor;
            },
            set(value) {
                this.internalConfig.leftRotor = value;
                this.$emit('update:modelValue', this.internalConfig);
            }
        },
        middleRotor: {
            get() {
                return this.internalConfig.middleRotor;
            },
            set(value) {
                this.internalConfig.middleRotor = value;
                this.$emit('update:modelValue', this.internalConfig);
            }
        },
        rightRotor: {
            get() {
                return this.internalConfig.rightRotor;
            },
            set(value) {
                this.internalConfig.rightRotor = value;
                this.$emit('update:modelValue', this.internalConfig);
            }
        },

        // Options are everything except the rotors that are already selected.
        leftOptions: {
            get() {
                return this.fullOptions.map(item => {
                    return {
                        $isDisabled: !!(item.name == this.middleRotor.name || item.name == this.rightRotor.name),
                        ...item,
                    };
                });
            }
        },
        middleOptions: {
            get() {
                return this.fullOptions.map(item => {
                    return {
                        $isDisabled: !!(item.name == this.leftRotor.name || item.name == this.rightRotor.name),
                        ...item,
                    };
                });
            }
        },
        rightOptions: {
            get() {
                return this.fullOptions.map(item => {
                    return {
                        $isDisabled: !!(item.name == this.leftRotor.name || item.name == this.middleRotor.name),
                        ...item,
                    };
                });
            }
        },
    },

    methods: {
        fetchOptions() {
            axios.get('/api/v1/rotors').then(response => {
                this.fullOptions = response.data;
            });
        },
    },

    mounted() {
        this.internalConfig = this.modelValue;

        this.fetchOptions();
    },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style lang="scss" scoped>
.rotor-row {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: -5px;
}
.rotor-wrap {
    min-width: 175px;
    margin: 5px;
}
</style>
