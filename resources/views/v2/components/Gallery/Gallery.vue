<template>

    <div class="Gallery" :class="isclasses">

        <div class="Gallery__images">

        <div
            class="Gallery__imagesRow"
            v-for="row in currentImages"
        >
                <img
                    v-for="item in row"
                    class="Gallery__image"
                    :src="item.small"
                    @click="render(0)"
                />

        </div>

        </div>

        <div class="Gallery__fullscreen" v-if="fullscreen">

            <component
                is="Icon"
                class="Gallery__close"
                icon="icon-close"
                size="xl"
                fill="white"
                @click.native="fullscreen = false, activeImage = -1">
            </component>

            <div
                class="Gallery__left"
                @click="prevImage"
                v-show="activeImage > 0"
            >

                <component is="Icon" icon="icon-arrow-left" size="xl" fill="white"></component>

             </div>

             <div
                class="Gallery__right"
                @click="nextImage"
                v-show="activeImage < images.length - 1"
            >

                <component is="Icon" icon="icon-arrow-right" size="xl" fill="white"></component>

            </div>

            <div class="Gallery__fullImageWrapper">

                <img class="Gallery__fullImage" :src="currentImages[activeImage].large" />

            </div>

            <div
                class="Gallery__fullMeta"
                v-html="currentImages[activeImage].meta"
            >
            </div>
            
        </div>

    </div>

</template>

<script>

import chunk from 'lodash.chunk'

import Icon from '../Icon/Icon.vue'

export default {

    components: {
        Icon
    },

    props: {
        isclasses: { default: '' },
        images: { default: '' }
    },

    data() {
        return {
            fullscreen: false,
            activeImage: false,
            currentImages: []
        }
    },

    methods: {
        render: function(index) {
            this.activeImage = index
            this.fullscreen = true
        },
        prevImage: function() {
            this.activeImage = this.activeImage - 1
        },
        nextImage: function() {
            this.activeImage = this.activeImage + 1
        }
    },

    mounted() {
        this.currentImages = this.images
            ? chunk(JSON.parse(decodeURIComponent(this.images)), 3)
            : []
    }

}

</script>
