<template>
    <div class="Loading" v-if="visible">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</template>

<script>
export default {
    props: {
        show: { default: false }
    },

    data() {
        return {
            visible: this.show
        }
    },
    watch: {
        show: function (show) {
            this.visible = show
        }
    },
}
</script>
