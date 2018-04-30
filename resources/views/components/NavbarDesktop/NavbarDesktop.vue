<template>

    <nav class="NavbarDesktop" :class="isclasses">

        <div class="NavbarDesktop__links">

            <a
                v-for="(link, index) in links"
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

            <div
                v-on-clickaway="onClickaway"
            >
                <a
                    v-if="! user"
                    :class="{ active: isActive }"
                    @click="onClick"
                >

                    <div class="NavbarDesktop__link NavbarDesktop__linkMytrip">

                        {{ title }}

                    </div>

                </a>

                <div v-if="user"
                    :class="{ active: isActive }"
                    @click="onClick"
                    class="NavbarDesktop__userImage"
                >

                    <component
                        v-if="user.badge"
                        is="Badge"
                        class="NavbarDesktop__badge"
                        :title="user.badge"
                    ></component>

                    <component
                        is="UserImage"
                        route="javascript:;"
                        :image="user.image"
                        :rank="user.rank"
                    >
                    </component>

                </div>

            </div>

            <div
                class="NavbarDesktop__popover"
                v-show="submenuOpen"
                transition="fadeZoom"
            >

                <div class="NavbarDesktop__arrowWrapper">

                    <div class="NavbarDesktop__arrow"></div>

                </div>

                <div class="NavbarDesktop__sublinks">

                    <a
                        v-for="(link, index) in sublinks"
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
        </div>

    </nav>

</template>

<script>
import { mixin as VueClickaway } from 'vue-clickaway'
import Badge from '../Badge/Badge.vue'
import UserImage from '../UserImage/UserImage.vue'

export default {
    components: { Badge, UserImage },

    mixins: [VueClickaway],

    props: {
        isclasses: { default: '' },
        links: { default: '' },
        sublinks: { default: '' },
        user: { default: '' },
        route: { default: '' },
        title: { default: '' }
    },

    methods: {
        onClickaway: function() {
            this.submenuOpen = false
            this.isActive = false
        },
        onClick: function() {
            this.isActive = !this.isActive

            if (this.isActive) {
                this.submenuOpen = true
            } else {
                this.submenuOpen = false
            }
        }
    },

    data() {
        return {
            submenuOpen: false,
            isActive: false
        }
    }
}
</script>
