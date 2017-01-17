<template>

    <div class="NavbarMobile" :class="isclasses">

        <div
            class="NavbarMobile__menuIcon"
            v-show="! menuOpen"
            @click.prevent="menuOpen = true"
        >
        
            <component
                is="Icon"
                v-if="! currentUser"
                icon="icon-menu"
                size="lg">
            </component>
        
            <div v-if="currentUser" class="NavbarMobile__userImage">

                <component
                    v-if="currentUser.badge"
                    is="Badge"
                    class="NavbarMobile__badge"
                    :title="currentUser.badge"
                ></component>

                <component
                    is="UserImage"
                    :route="currentUser.route"
                    :image="currentUser.image"
                    :rank="currentUser.rank"
                >
                </component>

            </div>

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

                    <div class="NavbarMobile__sublinkWrapper">

                        <div class="NavbarMobile__sublinkTitle">

                        {{ link.title }}

                        </div>

                    </div>

                </a>

                <a
                    v-for="(link, index) in currentSublinks"
                    :href="link.route"
                    key="index"
                >

                    <div class="NavbarMobile__sublinkWrapper">

                        <div class="NavbarMobile__sublinkTitle">

                        {{ link.title }}

                        </div>

                        <div
                            class="NavbarMobile__sublinkBadge"
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

   </div>

</template>

<script>

    import Badge from '../Badge/Badge.vue'
    import Icon from '../Icon/Icon.vue'
    import NavbarSearch from '../NavbarSearch/NavbarSearch.vue'
    import UserImage from '../UserImage/UserImage.vue'

    export default {
    
        components: {
            Badge,
            Icon,
            NavbarSearch,
            UserImage
        },

        props: {
            isclasses: { default: '' },
            links: { default: '' },
            sublinks: { default: '' },
            user: { default: '' }
        },

        data() {
            return {
                menuOpen: false,
                currentLinks: [],
                currentSublinks: [],
                currentUser: {}
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
            this.currentUser = this.user ? JSON.parse(decodeURIComponent(this.user)) : ''
        }

    }

</script>