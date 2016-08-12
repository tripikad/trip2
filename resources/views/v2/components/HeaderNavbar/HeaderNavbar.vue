<template>

    <nav class="HeaderNavbar" :class="isclasses">

        <div class="HeaderNavbar__links">

            <a
                v-for="link in links"
                :href="link.route"
                track-by="$index"
            >

                <div
                    @mouseover="toggleSubmenu(link)"
                    v-on-clickaway="submenuOpen = false"
                    class="HeaderNavbar__link"
                >

                    {{ link.title }}

                </div>  

            </a>
          
        </div>

        <div
            class="HeaderNavbar__popover"
            v-if="submenuOpen"
            transition="fadeZoom"
            v-on-clickaway="toggleSubmenu()"
        >

            <div class="HeaderNavbar__arrowWrapper">            
            
                <div class="HeaderNavbar__arrow"></div>
            
            </div>

            <div class="HeaderNavbar__sublinks">

                <a
                    v-for="link in sublinks"
                    :href="link.route"
                    track-by="$index"
                >

                    <div class="HeaderNavbar__sublink">

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