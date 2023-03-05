<template>
<div class="configuration">
    <div class="rotor-row">

        <div class="wrap">
            <label>Left Rotor</label>
            <rotor-select
                v-model="internalConfig.leftRotor"
                :all-rotors="fullRotorOptions"
                :other-rotors="[ internalConfig.middleRotor, internalConfig.rightRotor ]"
            />
            <index-select
                v-model="internalConfig.leftIndex"
                :index-options="indexOptions"
            />
        </div>

        <div class="wrap">
            <label>Middle Rotor</label>
            <rotor-select
                v-model="internalConfig.middleRotor"
                :all-rotors="fullRotorOptions"
                :other-rotors="[ internalConfig.leftRotor, internalConfig.rightRotor ]"
            />
            <index-select
                v-model="internalConfig.middleIndex"
                :index-options="indexOptions"
            />
        </div>

        <div class="wrap">
            <label>Right Rotor</label>
            <rotor-select
                v-model="internalConfig.rightRotor"
                :all-rotors="fullRotorOptions"
                :other-rotors="[ internalConfig.leftRotor, internalConfig.middleRotor ]"
            />
            <index-select
                v-model="internalConfig.rightIndex"
                :index-options="indexOptions"
            />
        </div>

    </div>

    <div class="index-row">

    </div>
</div>
</template>

<script>
import VueMultiselect from 'vue-multiselect';
import RotorSelect from './RotorSelect.vue';
import IndexSelect from './IndexSelect.vue';

export default {
    components: {
        VueMultiselect,
        RotorSelect,
        IndexSelect,
    },

    props: {
        modelValue: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            fullRotorOptions: [],
            indexOptions: []
        };
    },

    computed: {
        internalConfig: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },

    methods: {
        fetchRotorOptions() {
            axios.get('/api/v1/rotors').then(response => {
                this.fullRotorOptions = response.data;
            });
        },
        generateIndexOptions() {
            this.indexOptions = [];

            for (let i = 0; i < 26; i++) {
                this.indexOptions.push(i);
            }
        }
    },

    mounted() {
        this.internalConfig = this.modelValue;

        this.fetchRotorOptions();
        this.generateIndexOptions();
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

.wrap {
    min-width: 175px;
    margin: 5px;

    &>* {
        margin: 5px
    }
}
</style>
