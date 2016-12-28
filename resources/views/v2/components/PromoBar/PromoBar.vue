<template>

    <div v-show="open" class="PromoBar" :class="isclasses">

        <div class="PromoBar__titleWrapper">
            
            <div class="PromoBar__title">

                {{ title }}

            </div>

            <a class="PromoBar__route" :href="route">
              
                {{ route_title }}
            
            </a>

        </div>

        <div
            class="NavbarMobile__closeIcon"
            @click="open = false"
        >

            <component
                is="Icon"
                icon="icon-close"
                size="md"
            >
            </component>

        </div>

    </div>

</template>

<script>

    import Icon from '../Icon/Icon.vue'

    export default {

        components: { Icon },

        props: {
            isclasses: { default: '' },
            title: { default: '' },
            route_title: { default: '' },
            route: { default: '' }
        },

        data() {
            return {
                open: true
            }
        }

    }

</script>
