<template>
    <div class="wrap">
        <label>Input</label>
        <div>
            <input
                type="text"
                v-model="internalValue"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        modelValue: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            internalValue: '',
        };
    },

    computed: {
        enteredText: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },

    watch: {
        internalValue(value) {
            // Force to uppercase, and remove anything Enigma cannot handle.
            const trimmed = value.toUpperCase().replaceAll(/[^A-Z]/g, '');

            if (trimmed != value) {
                this.internalValue = trimmed;
            }

            this.enteredText = trimmed;
        }
    },

    mounted() {
        this.internalValue = this.modelValue;
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