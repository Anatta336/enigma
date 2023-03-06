<template>
    <div class="wrap">
        <button
            @click="onClick"
        >
            Encode
        </button>
    </div>
</template>

<script>
export default {
    props: {
        params: {
            type: Object,
            required: true,
        },
    },

    methods: {
        onClick() {
            console.log(this.params);
        }
    },
};
</script>

<style lang="scss" scoped>
.wrap {
    display: flex;
    align-items: center;
    flex-direction: column;

    &>* {
        margin: 5px
    }
}

button {
    min-width: 150px;
    height: 2.5rem;
    border: 0;
    border-radius: 5px;
    box-shadow: inset 0px 0px 3px 1px #eff2f1, 0px 0px 14px 3px rgba(215, 240, 255, 0), 0px 0px 8px 1px #4949495c;
    background-color: #9cceda;
    color: #2d2d44;
    transition: all 600ms cubic-bezier(0.1, 1.13, 0.41, 1.34);

    &:hover {
        box-shadow: inset 0px 0px 3px 1px #aec2cab8, 0px 0px 14px 3px rgb(215 240 255), 0px 0px 8px 1px rgb(73 73 73 / 0%);
        background-color: #f9fffe;
        color: #2d2d43a1;
    }
}
</style>