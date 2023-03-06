<template>
<div class="body">

    <section class="card">
        <header>
            <h1>Enigma</h1>
        </header>

        <div class="settings">
            <rotor-configuration
                v-model="params.rotors"
            />
        </div>

        <div class="input">
            <text-input
                v-model="params.input"
            />
        </div>

        <div class="output">
            <text-output
                :text="output"
            />
        </div>
    </section>
</div>
</template>

<script>
import RotorConfiguration from './RotorConfiguration.vue';
import TextInput from './TextInput.vue';
import TextOutput from './TextOutput.vue';

export default {
    components: {
        RotorConfiguration,
        TextInput,
        TextOutput,
    },
    data() {
        return {
            params: {
                rotors: {
                    leftRotor: {},
                    leftIndex: 0,
                    middleRotor: {},
                    middleIndex: 0,
                    rightRotor: {},
                    rightIndex: 0,
                },
                input: 'HELLONETMATTERS',
            },
            output: 'SOMETHING',
        };
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

    &>* {
        padding: 15px;
    }

    &>*:not(:last-child) {
        border-bottom: 1px solid #716e5042;
        box-shadow: 0px 1px 0px 0 #e7ede8c4;

    }

    header {
        text-align: center;
    }
}

</style>