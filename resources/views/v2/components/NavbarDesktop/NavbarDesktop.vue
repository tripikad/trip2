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
                @mouseenter="onMouseenter"
                @mouseleave="onMouseleave"
            >

                <div class="NavbarDesktop__link">

                    {{ title }}

                </div>  

            </a>

            <div v-if="currentUser" class="NavbarDesktop__userImage">

                <component
                    v-if="currentUser.badge"
                    is="Badge"
                    class="NavbarDesktop__badge"
                    :title="currentUser.badge"
                ></component>

                <component
                    @touchstart.native.prevent="onTouchstart"
                    @mouseenter.native="onMouseenter"
                    @mouseleave.native="onMouseleave"
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
            v-on-clickaway="onClickaway"
            @mouseenter="onMouseenter"
            @mouseleave="onMouseleave"
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

                    <div class="NavbarDesktop__sublinkWrapper">

                        <div class="NavbarDesktop__sublinkTitle">

                        {{ link.title }}

                        </div>

                        <div
                            class="NavbarDesktop__sublinkBadge"
                            v-if="link.badge"
                        >

                            <component
                                is="Badge"
                                isclasses="Badge--white"
                                :title="link.badge"
                            ></component>

                        </div>

                    </div>
              
                </a>

            </div>

        </div>

    </nav>

</template>

<script>

    import { mixin as VueClickaway } from 'vue-clickaway'
    import Badge from '../Badge/Badge.vue'
    import UserImage from '../UserImage/UserImage.vue'

    export default {

        components: { Badge, UserImage },

        mixins: [ VueClickaway ],

        props: {
            isclasses: { default: '' },
            links: { default: '' },
            sublinks: { default: '' },
            user: { default: '' },
            route: { default: '' },
            title: { default: '' },
        },

        methods: {
            onTouchstart() {
                this.submenuOpen = !this.submenuOpen
                this.touched = !this.touched
            },
            onMouseenter() {
                this.submenuOpen = true
                clearTimeout(this.leaving)
            },
            onMouseleave() {
                this.leaving = setTimeout(() => {
                    this.submenuOpen = false
                }, 1500)
            },
            onClickaway: function() {
                if (! this.touched) {
                    this.submenuOpen = false
                }
            },
        },

        data() {
            return {
                submenuOpen: false,
                currentLinks: [],
                currentSublinks: [],
                currentUser: {},
                leaving: null,
                touched: false
            }
        },

        mounted() {
            this.currentLinks = this.links ? JSON.parse(decodeURIComponent(this.links)) : ''
            this.currentSublinks = this.sublinks ? JSON.parse(decodeURIComponent(this.sublinks)) : ''
            this.currentUser = this.user ? JSON.parse(decodeURIComponent(this.user)) : ''
        }

    }

</script>