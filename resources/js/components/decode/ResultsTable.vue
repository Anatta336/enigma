<template>
    <table>
        <thead><tr>
            <td colspan="2">
                Left
            </td>
            <td colspan="2">
                Middle
            </td>
            <td colspan="2">
                Right
            </td>
        </tr></thead>
        <tbody>
            <result-row
                v-for="result in results"
                :key="result"
                :result-as-text="result"
            />
        </tbody>
    </table>
</template>
<script>
import ResultRow from './ResultRow.vue';

export default {
    components: {
        ResultRow,
    },

    props: {
        results: {
            type: Array,
            required: true,
        },
    },
};
</script>
<style lang="scss" scoped>
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    border-radius: 5px;

    :deep(thead) {
        background-color: #ddded8;

        td:first-child {
            border-top-left-radius: 5px;
        }

        td:last-child {
            border-top-right-radius: 5px;
        }

        td {
            width: 33.3%;
        }
    }

    :deep(td) {
        padding: 5px;
        text-align: center;
    }

    :deep(td:not(:first-child)) {
        border-left: 1px solid #00000026;
    }
    :deep(td:not(:last-child)) {
        border-right: 1px solid #00000026;
    }
}
</style>