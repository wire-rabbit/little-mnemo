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
                const acceptedKeys = [
                    'Backspace',
                    'Delete',
                    'Left',
                    'ArrowLeft',
                    'Right',
                    'ArrowRight'
                ];
                let acceptedKey = acceptedKeys.indexOf(event.key) >= 0;
                if ((!/^\d$/.test(event.key)) && !acceptedKey) {
                    event.preventDefault();
                } else if (this.numberData.length > 5 && !acceptedKey) {
                    event.preventDefault();
                }
            }
        },
        mounted: function () {
            this.$refs.primary_input.focus();
        }
    }
</script>
