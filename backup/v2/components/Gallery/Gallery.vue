<template>

    <div class="Gallery" :class="isclasses">

        <div class="Gallery__images">

            <div
                class="Gallery__imagesRow"
                v-for="row in currentImages"
            >
                    <div
                        v-for="item in row"
                        class="Gallery__image"
                        @click="render(0)"
                        :style="{backgroundImage: 'url(' + item.small + ')'}"
                    >
                        
                    </div>

            </div>

        </div>

        <div class="Gallery__buttonWrapper">

            <div class="Gallery__button" v-html="currentButton">
            </div>

        </div>

        <!--
        <div class="Gallery__fullscreen" v-show="fullscreen">

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
        -->
        
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
        images: { default: '' },
        button: { default: '' }
    },

    data() {
        return {
            fullscreen: false,
            activeImage: false,
            currentImages: [],
            currentButton: ''
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
        // this.currentImages = this.images
        //    ? chunk(JSON.parse(decodeURIComponent(this.images)), 3)
        //    : []
        var images = this.images ? JSON.parse(decodeURIComponent(this.images)) : []
        images = images.concat(
            Array(9 - images.length).fill({small: '/v2/svg/image_none.svg'})
        )
        this.currentImages = chunk(images, 3)

        this.currentButton = this.button ? JSON.parse(decodeURIComponent(this.button))[0] : []

    }

}

</script>
