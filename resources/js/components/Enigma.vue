<template>
<div class="body">

    <section class="card">
        <header>
            <h1>Enigma</h1>
        </header>

        <div class="content">
            <rotor-configuration
                v-model="rotors"
            />
        </div>
    </section>
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
                leftIndex: 0,
                middleRotor: {},
                middleIndex: 0,
                rightRotor: {},
                rightIndex: 0,
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
    color: #2d2d44;;
    border-radius: 5px;
    box-shadow: 3px 5px 10px 1px #00000063, inset 0px 0px 3px 1px #e7ede8;

    header {
        padding: 15px;
        border-bottom: 1px solid #716e5042;
        box-shadow: 0px 1px 0px 0 #e7ede8c4;
        text-align: center;
    }

    .content {
        padding: 20px;
    }
}

</style>