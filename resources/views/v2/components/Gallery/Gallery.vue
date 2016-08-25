<template>

    <div class="Gallery" :class="isclasses">

        <div class="Gallery__wrapper">

            <div class="Gallery__item" v-for="item in images">

                 <img class="Gallery__image" src="../images/{{item.small}}" @click="render(this.$index)"/>

            </div

        </div>

        <div class="Gallery__Fullscreen" v-if="active">

            <div class="Gallery__close"> 

                <component is="Icon" icon="icon-close" size="xl" fill="white" @click="active = false, activeImage = -1"></component>

            </div>


            <div class="Gallery__Fullitem" >

                <div class="Gallery__left" @click="activeImage--">

                    <component is="Icon" icon="icon-arrow-left" size="xl" fill="white"></component>

                 </div>

                <img class="Gallery__Fullimage" src="../images/{{images[activeImage]}}"/>

                <div class="Gallery__right" @click="activeImage++">

                    <component is="Icon" icon="icon-arrow-right" size="xl" fill="white"></component>

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
            images: { default: '' }
        },

        data() {
            return {
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

        ready() {
            this.images = this.images
                ? JSON.parse(decodeURIComponent(this.images))
                : []
        }

    }

</script>
