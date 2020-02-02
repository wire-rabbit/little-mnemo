<template>
    <div class="container">
        <div class="row justify-content-center">
            <primary-input
                :maxLength="10"
                @fetchWords="fetchWords"
            ></primary-input>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            fetchWords: function(num) {
                axios.post('/fetch', {
                    number: num
                }).then(function (response) {
                    console.log(response.data);
                }).catch(function (err) {
                    console.log(err);
                });
            }
        }
    }
</script>
