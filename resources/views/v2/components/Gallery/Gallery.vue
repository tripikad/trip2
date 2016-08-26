<template>

    <div class="Gallery" :class="isclasses">

        <div class="Gallery__wrapper">

                 <img class="Gallery__image col-4"
                    v-for="item in images"
                    track-by="$index"
                    :src="item.small"
                    @click="render(this.$index)"/>

        </div>

        <div class="Gallery__Fullscreen" v-if="active">

            <component is="Icon" class="Gallery--close" icon="icon-close" size="xl" fill="white" @click="active = false, activeImage = -1"></component>

            <div class="Gallery__left" @click="activeImage--" v-if="activeImage > 0">

                <component is="Icon" icon="icon-arrow-left" size="xl" fill="white"></component>

             </div>

             <div class="Gallery__right" @click="activeImage++" v-if="activeImage < images.length -1">

                    <component is="Icon" icon="icon-arrow-right" size="xl" fill="white"></component>

            </div>

            <div class="Gallery__Fullitem">

                <img class="Gallery__Fullimage" :src="images[activeImage].large"/>

                <div class="Gallery__imageinfo">

                    <div class="meta" ></div>

                    <span>{{ images[activeImage].title }}</span>

                    <a href="{{ images[activeImage].user.route }}">Lisas: {{ images[activeImage].user.name }}</a>

                </div>

            </div>

        </div>

    </div>

</template>

<script>

import Icon from '../Icon/Icon.vue'

export default {

    components: {
        Icon
    },

    props: {
        isclasses: { default: '' },
        images: { default: '' },
        title: { default: '' }
    },

    data() {
        return {
            active: false,
            activeImage: false
        }
    },

    methods: {
        render: function(index) {
            this.activeImage = index
            this.active = true
        }
    },

    ready() {
        this.images = this.images
            ? JSON.parse(decodeURIComponent(this.images))
            : []
    }

}

</script>
