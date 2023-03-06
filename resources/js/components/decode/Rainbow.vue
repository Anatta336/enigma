<template>
    <section>
        <header>
            <h1>Rainbow</h1>
        </header>

        <div>
            <text-input
                label="Plain Text"
                v-model="plaintext"
            />
        </div>

        <div>
            <text-input
                label="Encrypted"
                v-model="encrypted"
            />
        </div>

        <div>
            <lookup-button
                :plaintext="plaintext"
                :encrypted="encrypted"
                @found="onFound"
                @failed="onFailed"
            />
        </div>

        <div v-if="hasFailed">
            Nothing found.
        </div>
        <div v-else-if="hasResults">
            <results-table
                :results="results"
            />
        </div>

    </section>
</template>

<script>
import TextInput from '../shared/TextInput.vue';
import LookupButton from './LookupButton.vue';
import ResultsTable from './ResultsTable.vue';

export default {
    components: {
        TextInput,
        LookupButton,
        ResultsTable,
    },

    data() {
        return {
            plaintext: 'HELLONETMATTERS',
            encrypted: '',
            hasFailed: false,
            results: [],
        };
    },

    computed: {
        hasResults() {
            return this.results?.length > 0;
        },
    },

    methods: {
        onFound(results) {
            this.hasFailed = false;
            this.results = results;
        },
        onFailed() {
            this.hasFailed = true;
        },
    },
};
</script>

<style lang="scss" scoped>
section {
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