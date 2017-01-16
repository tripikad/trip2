<template>

    <div
        class="PhotoFullscreen"
        :class="isclasses"
        v-show="open"
        @click="open = false"
    >

        <img class="PhotoFullscreen__photo" :src="large" />

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
                open: false
            }
        },

        mounted() {
            this.$events.$on('photo', (photo) => {
                this.large = photo
                this.open = true
                console.log('Hmm')
            })
        }

    }

</script>
