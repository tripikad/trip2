<template>

    <div class="Gallery" :class="isclasses">

        <div class="Gallery__wrapper">

            <div class="Gallery__item" v-for="item in images">

                 <img class="Gallery__image" src="../images/{{item}}" @click="render(this.$index)"/>

            </div

        </div>

        <div class="Gallery__Fullscreen" v-if="active">

             <component is="Icon" icon="icon-close" size="lg" fill="white" @click="active = false, activeImage = -1"></component>

            <div class="Gallery__Fullitem">

                <component is="Icon" icon="icon-arrow-left" size="lg" fill="white" @click="activeImage--"></component>

                 <img class="Gallery__Fullimage" src="../images/{{images[activeImage]}}"/>

                  <component is="Icon" icon="icon-arrow-right" size="lg" fill="white" @click="activeImage++"></component>

            </div

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
        },

        data() {
            return {
                images: ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'],
                active: false,
                activeImage: -1,
            }
        },

        methods: {
            render: function(index) {
                this.activeImage = index;
                this.active = true;
            }
        },

    }

</script>
