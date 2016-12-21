<template>

    <div class="NavbarMobile" :class="isclasses">

        <div
            class="NavbarMobile__menuIcon"
            v-show="! menuOpen"
            @click="menuOpen = true"
        >
        
            <component is="Icon" icon="icon-menu" size="lg"></component>
        
        </div>

        <div
            v-show="menuOpen"
            class="NavbarMobile__menu"
            transition="fadeZoom"
        >

            <div class="NavbarMobile__header">

                <div class="NavbarMobile__search">
                
                    <component is="NavbarSearch" class="NavbarSearch--white" size="lg"></component>
                
                </div>

                <div
                    class="NavbarMobile__closeIcon"
                    @click="menuOpen = false"
                >
                    
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

    import NavbarSearch from '../NavbarSearch/NavbarSearch.vue'
    import Icon from '../Icon/Icon.vue'

    export default {
    
        components: {
            NavbarSearch,
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
            bla() {
                this.menuOpen = false
                console.log(this.menuOpen)
            },
            toggle: function() {
                this.menuOpen = !this.menuOpen
                console.log(this.menuOpen)
            }
        },

        mounted() {
            this.currentLinks = this.links ? JSON.parse(decodeURIComponent(this.links)) : ''
            this.currentSublinks = this.sublinks ? JSON.parse(decodeURIComponent(this.sublinks)) : ''
        }

    }

</script>