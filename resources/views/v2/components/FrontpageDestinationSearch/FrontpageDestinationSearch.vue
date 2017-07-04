<template>

    <div class="FrontpageSearchDestination" :class="isclasses">

        <div class="FrontpageSearchDestination__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="lg"
            ></component>

        </div>

        <div class="FrontpageSearchDestination__search">

        <component
            is="Multiselect"
            v-model="selected"
            :options="options"
            track-by="name"
            label="name"
            :placeholder="placeholder"
            tag-placeholder=""
            @input="onInput"
        >
        </component>

        </div>

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    import Icon from '../Icon/Icon.vue'

    export default {

        components: { Multiselect, Icon },

        props: {
            isclasses: { default: '' },
            options: { default: [] },
            placeholder: { default: '' },
            route: { default: '' },
        },

        data() {
            return {
                selected: {}
            }
        },


        computed: {
            currentRoute() {
                return this.route.replace(
                    '0', this.selected.slug ? this.selected.slug : '0'
                )
            }
        },

        methods: {
            onInput() {
                window.location = this.currentRoute
            }
        }
    }

</script>
