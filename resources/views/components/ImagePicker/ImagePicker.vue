<template>
    <div class="ImagePicker" v-if="show">
        <div class="ImagePicker__close" @click="show = false">×</div>

        <component :is="'ImageUpload'"></component>

        <div class="ImagePicker__card" v-for="(image, index) in images" :key="index" @click="onClick(image)">
            <img class="ImagePicker__image" :src="image.small" />

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
    data: () => ({
        show: false,
        images: [],
        target: ''
    }),
    methods: {
        onClick(image) {
            this.$events.$emit('imagepicker.insert', {
                id: image.id,
                small: image.small,
                large: image.large,
                target: this.target
            })
        },
        getImages() {
            this.$http.get(this.$globalProps.imagePickerRoute).then(res => {
                this.images = res.data
            })
        }
    },
    mounted() {
        this.$events.$on('imagepicker.show', target => {
            this.getImages()
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
