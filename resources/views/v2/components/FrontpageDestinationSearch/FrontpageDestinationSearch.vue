<template>

    <div class="FrontpageSearchDestination" :class="isclasses">

        <component
            is="Multiselect"
            v-model="selected"
            :options="currentOptions"
            track-by="name"
            label="name"
            :placeholder="placeholder"
            tag-placeholder=""
            @input="onInput"
        >
        </component>

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            options: { default: '' },
            placeholder: { default: '' },
            route: { default: '' },
        },

        data() {
            return {
                currentOptions: [],
                selected: {}
            }
        },


        computed: {
            currentRoute() {
                return this.route.replace(
                    '0', this.selected.id ? this.selected.id : '0'
                )
            }
        },

        methods: {
            onInput() {
                window.location = this.currentRoute
            }
        },

        mounted() {
            this.currentOptions = JSON.parse(decodeURIComponent(this.options))
        }

    }

</script>
