<template>
    <div class="rotor-row">
        <rotor-select
            label="Left Rotor"
            v-model="internalConfig.leftRotor"
            :all-rotors="fullOptions"
            :other-rotors="[ internalConfig.middleRotor, internalConfig.rightRotor ]"
        />
        <rotor-select
            label="Middle Rotor"
            v-model="internalConfig.middleRotor"
            :all-rotors="fullOptions"
            :other-rotors="[ internalConfig.leftRotor, internalConfig.rightRotor ]"
        />
        <rotor-select
            label="Right Rotor"
            v-model="internalConfig.rightRotor"
            :all-rotors="fullOptions"
            :other-rotors="[ internalConfig.leftRotor, internalConfig.middleRotor ]"
        />
    </div>

</template>

<script>
import VueMultiselect from 'vue-multiselect';
import RotorSelect from './RotorSelect.vue';

export default {
    components: {
        VueMultiselect,
        RotorSelect,
    },

    props: {
        modelValue: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            internalConfig: {
                leftRotor: {},
                middleRotor: {},
                rightRotor: {},
            },
            fullOptions: [],
        };
    },

    computed: {

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

<style scoped>
.rotor-row {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: -5px;
}
</style>
