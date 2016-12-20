<template>

    <div class="NavbarMobile" :class="isclasses">

        <div
            class="NavbarMobile__menuIcon"
            v-if="! menuOpen"
            @click.native="toggle()"
        >
        
            <component is="Icon" icon="icon-menu" size="lg"></component>
        
        </div>

        <div
            v-else
            class="NavbarMobile__menu"
            transition="fadeZoom"
        >

            <div class="NavbarMobile__header">

                <div class="NavbarMobile__search">
                
                    <component is="HeaderSearch" class="HeaderSearch--white" size="lg"></component>
                
                </div>

                <div class="NavbarMobile__closeIcon" @click.native="menuOpen = false">
                    
                    <component is="Icon" icon="icon-close" size="xl"></component>

                </div>

            </div>

            <div class="NavbarMobile__links">
       
                <a
                    v-for="(link, index) in currentLinks"
                    :href="link.route"
                    key="index"
                >

                    <div class="NavbarMobile__link">
                        
                        {{ link.title }}
                        
                    </div>

                </a>

                <a
                    v-for="(link, index) in currentSublinks"
                    :href="link.route"
                    key="index"
                >

                    <div class="NavbarMobile__link">
                        
                        {{ link.title }}
                        
                    </div>

                </a>

            </div>

       </div>

   </div>

</template>

<script>

    import HeaderSearch from '../NavbarSearch/NavbarSearch.vue'
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
                menuOpen: false,
                currentLinks: [],
                currentSublinks: []
            }
        },

        methods: {
            toggle: function() {
                console.log('bla')
                this.menuOpen = !this.menuOpen
            }
        },

        mounted() {
            this.currentLinks = this.links ? JSON.parse(decodeURIComponent(this.links)) : ''
            this.currentSublinks = this.sublinks ? JSON.parse(decodeURIComponent(this.sublinks)) : ''
        }

    }

</script>