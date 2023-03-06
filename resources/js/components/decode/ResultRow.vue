<template>
    <tr>
        <td>{{ leftRotorName }}</td>
        <td>{{ leftRotorIndex }}</td>
        <td>{{ middleRotorName }}</td>
        <td>{{ middleRotorIndex }}</td>
        <td>{{ rightRotorName }}</td>
        <td>{{ rightRotorIndex }}</td>
    </tr>
</template>
<script>
export default {
    props: {
        resultAsText: {
            type: String,
            required: true,
        }
    },

    computed: {
        resultAsArray() {
            return this.resultAsText.split('.');
        },
        leftRotorName() {
            return this.resultAsArray[0];
        },
        middleRotorName() {
            return this.resultAsArray[2];
        },
        rightRotorName() {
            return this.resultAsArray[4];
        },
        leftRotorIndex() {
            return this.resultAsArray[1];
        },
        middleRotorIndex() {
            return this.resultAsArray[3];
        },
        rightRotorIndex() {
            return this.resultAsArray[5];
        },
    },
};
</script>
<style lang="scss" scoped>

</style>
