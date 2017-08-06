<template>

    <div
        class="PhotoFullscreen"
        :class="isclasses"
        v-show="open"
        @click="open = false"
    >

        <img class="PhotoFullscreen__photo" :src="large" />

        <div class="PhotoFullscreen__meta" v-html="meta"></div>

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
        },

        data() {
            return {
                large: '',
                meta: '',
                open: false
            }
        },

        mounted() {
            this.$events.$on('photo', (photo) => {
                this.large = photo.large
                this.meta = photo.meta
                this.open = true
            })
        }

    }

</script>
