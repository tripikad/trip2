<template>

    <div class="NavbarSearch" :class="[ isclasses, { 'NavbarSearch--active': active }]">

        <div class="NavbarSearch__icon">

            <component
                is="Icon"
                icon="icon-search"
                :size="size"
                @click.native="active = ! active"
            ></component>

        </div>

        <input
            class="NavbarSearch__input"
            type="text"
            size="12"
            v-model="keywords"
            @keyup.enter="search()"
            v-focus="active"
            v-if="active"
            @click="active = true"
        >

    </div>

</template>

<script>

import Icon from '../Icon/Icon.vue'
import { focus } from 'vue-focus'

export default {

    components: {
        Icon
    },

    directives: { focus },

    props: {
        isclasses: { default: '' },
        size: { default: 'md' }
    },

    data: function() {
        return {
            active: false,
            keywords: ''
        }
    },

    methods: {
        search: function() {
            window.location = '/search?q=' + this.keywords
        }
    }

}

</script>
