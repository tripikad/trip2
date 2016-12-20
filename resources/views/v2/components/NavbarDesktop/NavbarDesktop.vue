<template>

    <nav class="NavbarDesktop" :class="isclasses">

        <div class="NavbarDesktop__links">

            <a
                v-for="(link, index) in currentLinks"
                :href="link.route"
                track-by="index"
            >

                <div
                    @mouseover="toggleSubmenu(link)"
                    v-on-clickaway="submenuOpen = false"
                    class="NavbarDesktop__link"
                >

                    {{ link.title }}

                </div>  

            </a>
          
        </div>

        <div
            class="NavbarDesktop__popover"
            v-if="submenuOpen"
            transition="fadeZoom"
            v-on-clickaway="toggleSubmenu()"
        >

            <div class="NavbarDesktop__arrowWrapper">            
            
                <div class="NavbarDesktop__arrow"></div>
            
            </div>

            <div class="NavbarDesktop__sublinks">

                <a
                    v-for="(link, index) in currentSublinks"
                    :href="link.route"
                    track-by="index"
                >

                    <div class="NavbarDesktop__sublink">

                        {{ link.title }}

                    </div>
              
                </a>

            </div>

        </div>

    </nav>

</template>

<script>

    import { mixin as VueClickaway } from 'vue-clickaway'

    export default {

        mixins: [ VueClickaway ],

        props: {
            isclasses: { default: '' },
            links: { default: '' },
            sublinks: { default: '' }
        },

        methods: {
            toggleSubmenu: function(link) {
                if (link.menu) {
                    this.submenuOpen = !this.submenuOpen
                }
            }
        },

        data() {
            return {
                submenuOpen: false,
                currentLinks: [],
                currentSublinks: []
            }
        },

        mounted() {
            this.currentLinks = this.links
                ? JSON.parse(decodeURIComponent(this.links))
                : ''
            this.currentSublinks = this.sublinks
                ? JSON.parse(decodeURIComponent(this.sublinks))
                : ''
        }

    }

</script>