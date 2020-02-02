<template>
    <div class="primary-input container-fluid">
        <div class="row justify-content-center">
            <div>
                <textarea v-model="numberData"
                          rows="1"
                          class="primary-input"
                          ref="primary_input"
                          @keydown="nextDigit"
                ></textarea>
            </div>
        </div>
        <div class="row justify-content-center">
            <button type="button"
                    class="btn btn-primary centered fetch-button"
                    @click="fetchWords"
            >Fetch Word List</button>
        </div>
        <div class="row justify-content-center" v-if="hasErrors">
            <div class="alert alert-danger" role="alert">
                <span class="alert-text">Some Kind of Alert</span>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true" @click="dismissAlert">&times;</span>
                </button>
            </div>
        </div>
    </div>
</template>

<style>
    .primary-input {
        font-family: 'Raleway', sans-serif;
    }

    .alert-text {
        padding-right: 3em;
     }

    .fetch-button {
        padding: 0.5em;
        margin: 1.5em;
    }

    textarea.primary-input {
        border: 2px solid rgba(200, 200, 200, 0.5);
        resize: none;
        outline: none;
        background: transparent;
        font-family: 'Inconsolata', monspace;
        font-size: 4em;
        text-align: center;
    }
</style>

<script>
    export default {
        props: {
            maxLength: {
                type: Number,
                default: 5
            }
        },
        data: function () {
            return {
                numberData: '',
                hasErrors: false
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
                } else if (this.numberData.length >= this.maxLength && !acceptedKey) {
                    event.preventDefault();
                }
                this.hasErrors = false;
            },
            fetchWords: function () {
                if (this.numberData.length === 0) {
                    this.hasErrors = true;
                }
            },
            dismissAlert: function () {
                this.hasErrors = false;
            }
        },
        mounted: function () {
            this.$refs.primary_input.focus();
        }
    }
</script>
