<template>

    <div class="HeaderSearch" :class="[ isclasses, { 'HeaderSearch--active': active }]">

        <div class="HeaderSearch__icon">

            <component
                is="Icon"
                icon="icon-search"
                :size="iconsize"
                @click="active = ! active"
            ></component>

        </div>

        <input
            class="HeaderSearch__input"
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
        keywords: { default: '' },
        iconsize: { default: 'md' }
    },

    data: function() {
        return {
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
