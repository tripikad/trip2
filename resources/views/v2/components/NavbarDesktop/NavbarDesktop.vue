<template>

    <nav class="NavbarDesktop" :class="isclasses">

        <div class="NavbarDesktop__links">

            <a
                v-for="(link, index) in currentLinks"
                :href="link.route"
                key="index"
            >

                <div
                    @clickaway="submenuOpen = false"
                    class="NavbarDesktop__link"
                >

                    {{ link.title }}

                </div>  

            </a>

            <a
                v-if="! currentUser"
                :href="route"
                @mouseover="toggleSubmenu()"
            >

                <div class="NavbarDesktop__link">

                    {{ title }}

                </div>  

            </a>

            <div v-if="currentUser" class="NavbarDesktop__userImage">

            <component
                @mouseover.native="toggleSubmenu()"
                is="UserImage"
                :route="currentUser.route"
                :image="currentUser.image"
                :rank="currentUser.rank"
            >
            </component>
          
            </div>

        </div>

        <div
            class="NavbarDesktop__popover"
            v-show="submenuOpen"
            transition="fadeZoom"
            v-on-clickaway="closeSubmenu"
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
    import UserImage from '../UserImage/UserImage.vue'

    export default {

        components: { UserImage },

        mixins: [ VueClickaway ],

        props: {
            isclasses: { default: '' },
            links: { default: '' },
            sublinks: { default: '' },
            user: { default: '' },
            route: { default: '' },
            title: { default: '' }
        },

        methods: {
            closeSubmenu: function() {
                this.submenuOpen = false
            },
            toggleSubmenu: function() {
                this.submenuOpen = !this.submenuOpen
            }
        },

        data() {
            return {
                submenuOpen: false,
                currentLinks: [],
                currentSublinks: [],
                currentUser: {}
            }
        },

        mounted() {
            this.currentLinks = this.links ? JSON.parse(decodeURIComponent(this.links)) : ''
            this.currentSublinks = this.sublinks ? JSON.parse(decodeURIComponent(this.sublinks)) : ''
            this.currentUser = this.user ? JSON.parse(decodeURIComponent(this.user)) : ''
        }

    }

</script>