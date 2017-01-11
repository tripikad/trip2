<template>

    <div
        class="FrontpageSearch"
        :class="[ isclasses, { 'FrontpageSearch--active': active }]">

        <div class="FrontpageSearch__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="lg"
                @click.native="active = ! active"
            ></component>

        </div>

        <input
            class="FrontpageSearch__input"
            type="text"
            size="34"
            v-model="keywords"
            v-focus="active"
            @keyup.enter="search()"
            @click="active = true"
            :placeholder="active ? '' : title"
        >

    </div>

</template>

<script>

    import Icon from '../Icon/Icon.vue'
    import { focus } from 'vue-focus'

    export default {

        components: { Icon },

        directives: { focus },

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
            }
        }

    }

</script>
