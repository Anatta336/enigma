<template>
    <div class="body">
        <enigma-card />
        <rainbow-card />
    </div>
</template>
<script>
import EnigmaCard from './encode/Enigma.vue';
import RainbowCard from './decode/Rainbow.vue';

export default {
    components: {
        EnigmaCard,
        RainbowCard,
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style lang="scss" scoped>
.body {
    display: flex;
    min-width: 100%;
    min-height: 100vh;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    background-color: #a7b7de;
    flex-wrap: wrap;

    &>* {
        margin: 20px;
    }
}
</style>