<template>
    <div class="container">
<textarea class="primary-input" ref="primary_input"></textarea>
    </div>
</template>

<style>
    textarea.primary-input {
        border: none;
        resize: none;
        outline: none;
        background: transparent;
        font-family: 'Inconsolata', monspace;
        font-size: 4em;
    }
</style>

<script>
    export default {
        mounted: function () {
            this.$refs.primary_input.focus();
        }
    }
</script>
