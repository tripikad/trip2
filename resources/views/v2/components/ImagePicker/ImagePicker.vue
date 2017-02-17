<template>

    <div class="ImagePicker" v-if="show">
    
        <div class="ImagePicker__close" @click="show = false">×</div>

        <component is="ImageUpload"></component>

        <div
            class="ImagePicker__card"
            v-for="image in images"
            @click="onClick(image)"
        >
            <img class="ImagePicker__image" :src="image.route" />

            <div class="ImagePicker__title">
                {{ image.title }}
            </div>

        </div>

    </div>

</template>

<script>

    import ImageUpload from '../ImageUpload/ImageUpload.vue'

    export default {
        components: {
            ImageUpload
        },
        props: {
            route: {default: ''}
        },
        data: () => ({
            show: false,
            images: [],
            target: ''
        }),
        methods: {
            onClick(image) {
                this.$events.$emit('imagepicker.insert', {
                    id: image.id, target: this.target
                })
            },
            getImages() {
                this.$http.get(this.route).then(res => {
                    this.images = res.body
                })
            }
        },
        mounted() {
            this.getImages()

            this.$events.$on('imagepicker.show', (target) => {
                this.show = true
                this.target = target

            })
            this.$events.$on('imagepicker.hide', () => {
                this.show = false

            })
            this.$events.$on('imageupload.created', () => {
                this.getImages()
            })
        }
    }

</script>
