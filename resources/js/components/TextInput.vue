<template>
    <div class="wrap">
        <label>Input</label>
        <div>
            <input
                type="text"
                v-model="internalValue"
                ref="text-input"
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
            const element = this.$refs['text-input'];
            const initialPosition = element.selectionStart;

            // Force to uppercase, and remove anything Enigma cannot handle.
            const trimmed = value.toUpperCase().replaceAll(/[^A-Z]/g, '');

            // Bit if a fiddle, but this avoids the caret jumping to the end of the text input.
            if (trimmed.length != value.length) {
                element.selectionEnd = initialPosition - 1;
                this.$nextTick(() => {
                    element.selectionEnd = initialPosition - 1;
                })
            } else {
                element.selectionEnd = initialPosition;
                this.$nextTick(() => {
                    element.selectionEnd = initialPosition;
                })
            }

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