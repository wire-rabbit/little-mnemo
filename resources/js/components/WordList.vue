
<template>
    <div class="container">
        <ul class="list-group">
            <li v-for="(word, index) in words"
                :class="listClasses(index)"
            >
                {{ word }}
            </li>
        </ul>
    </div>
</template>

<style>
    .list-group-item {
        font-family: 'Raleway', sans-serif;
    }
</style>

<script>
    export default {
        props: {
            words: Array
        },
        methods: {
            listClasses: function (i) {
                return {
                    'list-group-item': true,
                    'list-group-item-light': i % 2 === 0,
                    'list-group-item-secondary': i % 2 !== 0
                }
            }
        }
    }
</script>
