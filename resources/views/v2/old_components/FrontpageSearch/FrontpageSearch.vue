<template>

    <div
        class="FrontpageSearch"
        :class="[ isclasses, { 'FrontpageSearch--active': active }]"
        v-on-clickaway="toggleActive"
    >

        <div class="FrontpageSearch__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="lg"
                @click.native="toggleActive"
            ></component>

        </div>

        <input
            class="FrontpageSearch__input"
            type="text"
            size="34"
            v-model="keywords"
            v-focus="active"
            @keyup.enter="search"
            @click="active = true"
            :placeholder="active ? '' : title"
        >

    </div>

</template>

<script>

    import { focus } from 'vue-focus'
    import { mixin as VueClickaway } from 'vue-clickaway'

    import Icon from '../Icon/Icon.vue'

    export default {

        components: { Icon },

        directives: { focus },

        mixins: [ VueClickaway ],

        props: {
            isclasses: { default: '' },
            title: { default: '' }
        },

        data() {
            return {
                keywords: '',
                active: false
            }
        },

        methods: {
            search: function() {
                window.location = '/search?q=' + this.keywords
            },
            toggleActive: function() {
                this.active = ! this.active
            }
        }

    }

</script>
