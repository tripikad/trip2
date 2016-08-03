<template>

    <div v-show="false">{{{ svg }}}</div>

</template>

<script>

    export default {

        props: {
            route: {}
        },

        data: function() {
            return {
                svg: {}
            }
        },

        ready() {
            this.$http.get(this.route).then(function(res) {
                this.svg = res.data
            })
        }

    }

</script>