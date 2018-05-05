<template>

    <div v-show="false" v-html="svg"></div>

</template>

<script>
export default {
    props: {
        route: { default: '' }
    },

    data: function() {
        return {
            svg: {}
        }
    },

    mounted() {
        this.$http.get(this.route).then(res => {
            this.svg = res.data
        })
    }
}
</script>
