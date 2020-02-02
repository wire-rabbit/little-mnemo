<template>
    <div class="container">
        <textarea v-model="numberData"
                  class="primary-input"
                  ref="primary_input"
                  @keydown="nextDigit"
        ></textarea>
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
        data: function () {
            return {
                numberData: ''
            };
        },
        methods: {
            nextDigit: function (event) {
                if ((!/^\d$/.test(event.key)) || this.numberData.length > 5) {
                    event.preventDefault();
                }
            }
        },
        mounted: function () {
            this.$refs.primary_input.focus();
        }
    }
</script>
