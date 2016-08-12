<template>

    <div class="HeaderNavbarMobile" :class="isclasses">

        <div
            class="HeaderNavbarMobile__menuIcon"
            v-if="! menuOpen"
            @click="toggle()"
        >
        
            <component is="Icon" icon="icon-menu" size="lg"></component>
        
        </div>

        <div
            v-else
            class="HeaderNavbarMobile__menu"
            transition="fadeZoom"
        >

            <div class="HeaderNavbarMobile__header">

                <div class="HeaderNavbarMobile__search">
                
                    <component is="headerSearch"></component>
                
                </div>

                <div class="HeaderNavbarMobile__closeIcon" @click="toggle()">
                    
                    <component is="Icon" icon="icon-close" size="lg"></component>

                </div>

            </div>

            <div class="HeaderNavbarMobile__links">
       
                <a
                    v-for="link in links"
                    :href="link.route"
                    track-by="$index"
                >

                    <div class="HeaderNavbarMobile__link">
                        
                        {{ link.title }}
                        
                    </div>

                </a>

                <a
                    v-for="link in sublinks"
                    :href="link.route"
                    track-by="$index"
                >

                    <div class="HeaderNavbarMobile__link">
                        
                        {{ link.title }}
                        
                    </div>

                </a>

            </div>

       </div>

   </div>

</template>

<script>

    import HeaderSearch from '../HeaderSearch/HeaderSearch.vue'
    import Icon from '../Icon/Icon.vue'

    export default {
    
        components: {
            HeaderSearch,
            Icon
        },

        props: {
            isclasses: { default: '' },
            links: { default: '' },
            sublinks: { default: '' }
        },

        data() {
            return {
                menuOpen: false
            }
        },

        methods: {
            toggle: function() {
                this.menuOpen = !this.menuOpen
            }
        },

        ready() {
            this.links = this.links ? JSON.parse(decodeURIComponent(this.links)) : ''
            this.sublinks = this.sublinks ? JSON.parse(decodeURIComponent(this.sublinks)) : ''
        }

    }

</script>