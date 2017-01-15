<template>

    <div
        class="PhotoFullscreen"
        :class="isclasses"
        v-show="open"
        @click="open = false"
    >

        <div class="PhotoFullscreen__photo">

            <img :src="large" />

        </div>

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
