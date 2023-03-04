<template>
<div>
    <h1>Example</h1>
    <p>This is a Vue component. {{something}}</p>
</div>
</template>

<script>
export default {
    data: () => {
        return {
            something: 123,
        };
    },
};
</script>

<style lang="scss" scoped>


p {
    font-size: 16px;
}
</style>