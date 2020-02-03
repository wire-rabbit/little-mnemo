<template>
    <div class="container">
        <div class="row justify-content-center">
            <primary-input
                :maxLength="10"
                @fetchWords="fetchWords"
            ></primary-input>
        </div>
    <word-list :words="matchedWords"></word-list>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                matchedWords: []
            }
        },
        methods: {
            fetchWords: function(num) {
                const that = this;
                axios.post('/fetch', {
                    number: num
                }).then(function (response) {
                    that.matchedWords = response.data;
                }).catch(function (err) {
                    console.log(err);
                });
            }
        }
    }
</script>
