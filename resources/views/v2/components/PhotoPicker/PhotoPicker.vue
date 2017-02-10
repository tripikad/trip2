<template>

    <div class="PhotoPicker" v-if="show">
    
        <div class="PhotoPicker__close" @click="show = false">×</div>

        <div
            class="PhotoPicker__photo"
            v-for="photo in photos"
            @click="onClick(photo)"
        >
            <img :src="photo.src" />

        </div>

    </div>

</template>

<script>

    export default {
        props: {
            route: {default: ''}
        },
        data: () => ({
            show: true,
            photos: []
        }),
        methods: {
           onClick(image) {
                this.$events.$emit('photopicker.insert', image.id)
           } 
        },
        mounted() {
            this.$http.get(this.route).then(res => {
                this.photos = res.body
            })
            this.$events.$on('photopicker.show', () => {
                this.show = true

            })
            this.$events.$on('photopicker.hide', () => {
                this.show = false

            })
        }
    }

</script>
