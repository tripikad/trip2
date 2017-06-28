<template>

    <div class="NavbarMobile" :class="isclasses">

        <div
            class="NavbarMobile__menuIcon"
            v-show="! menuOpen"
            @click.prevent="menuOpen = true"
        >
        
            <component
                is="Icon"
                v-if="! user"
                icon="icon-menu"
                size="lg">
            </component>
        
            <div v-if="user" class="NavbarMobile__userImage">

                <component
                    v-if="user.badge"
                    is="Badge"
                    class="NavbarMobile__badge"
                    :title="user.badge"
                ></component>

                <component
                    is="UserImage"
                    :route="user.route"
                    :image="user.image"
                    :rank="user.rank"
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
                    v-for="(link, index) in links"
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
                    v-for="(link, index) in sublinks"
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
                menuOpen: false
            }
        },

        methods: {
            toggle: function() {
                this.menuOpen = !this.menuOpen
                console.log(this.menuOpen)
            }
        }

    }

</script>