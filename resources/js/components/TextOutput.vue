<template>
    <div class="wrap">
        <label>Output</label>
        <div>
            <input
                type="text"
                :value="text"
                readonly
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped>
.wrap {
    display: flex;
    flex-direction: column;

    min-width: 175px;

    &>* {
        margin: 5px
    }
}
label {
    display: block;
}
input {
    width: 100%;
    border: 1px solid #e8e8e8;
    height: 2.5rem;
    padding: 0px 10px;
    border-radius: 5px;
}
</style>