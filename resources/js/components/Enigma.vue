<template>
<div class="body">

    <div class="card">
        <h1>Enigma</h1>

        <rotor-configuration
            v-model="rotors"
        />
    </div>
</div>
</template>

<script>
import RotorConfiguration from './RotorConfiguration.vue';

export default {
    components: {
        RotorConfiguration,
    },
    data() {
        return {
            rotors: {
                leftRotor: {},
                middleRotor: {},
                rightRotor: {},
            },
        };
    },
    methods: {

    },
};
</script>

<style lang="scss" scoped>
.rotor-selects {
    display: flex;
    flex-direction: row;
}

.body {
    display: flex;
    width: 100%;
    height: 100vh;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background-color: #a7b7de;
}

.card {
    background-color: #bec6af;
    padding: 20px;
    color: #141416;
    border-radius: 5px;
    box-shadow: 3px 5px 10px 1px #00000063, inset 0px 0px 3px 1px #e7ede8;
}

</style>