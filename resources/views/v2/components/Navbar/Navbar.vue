<template>

    <nav class="Navbar" :class="isclasses">

        <div class="Navbar__links">

            <a
                v-for="link in links"
                :href="link.route"
                track-by="$index"
            >

                <div
                    @mouseover="toggleSubmenu(link)"
                    v-on-clickaway="submenuOpen = false"
                    class="Navbar__link"
                >

                    {{ link.title }}

                </div>  

            </a>
          
        </div>

        <div
            class="Navbar__popover"
            v-if="submenuOpen"
            transition="fadeZoom"
            v-on-clickaway="toggleSubmenu()"
        >

            <div class="Navbar__arrowWrapper">            
            
                <div class="Navbar__arrow"></div>
            
            </div>

            <div class="Navbar__sublinks">

                <a
                    v-for="link in sublinks"
                    :href="link.route"
                    track-by="$index"
                >

                    <div class="Navbar__sublink">

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
                submenuOpen: false
            }
        },

        ready() {
            this.links = this.links
                ? JSON.parse(decodeURIComponent(this.links))
                : ''
            this.sublinks = this.sublinks
                ? JSON.parse(decodeURIComponent(this.sublinks))
                : ''
        }

    }

</script>