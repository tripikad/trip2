<template>

    <div class="PhotoPicker" v-if="show">
    
        <div class="PhotoPicker__close" @click="show = false">×</div>

        <div
            class="PhotoPicker__card"
            v-for="photo in photos"
            @click="onClick(photo)"
        >
            <img class="PhotoPicker__photo" :src="photo.route" />

            <div class="PhotoPicker__title">
                {{ photo.title }}
            </div>

        </div>

    </div>

</template>

<script>

    export default {
        props: {
            route: {default: ''}
        },
        data: () => ({
            show: false,
            photos: [],
            target: ''
        }),
        methods: {
           onClick(image) {
                this.$events.$emit('photopicker.insert', {
                    id: image.id, target: this.target
                })
           } 
        },
        mounted() {
            this.$http.get(this.route).then(res => {
                this.photos = res.body
            })
            this.$events.$on('photopicker.show', (target) => {
                this.show = true
                this.target = target

            })
            this.$events.$on('photopicker.hide', () => {
                this.show = false

            })
        }
    }

</script>
