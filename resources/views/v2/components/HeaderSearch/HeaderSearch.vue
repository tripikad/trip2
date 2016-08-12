<template>

    <div class="HeaderSearch" :class="{ 'HeaderSearch--active': active }">

        <div class="HeaderSearch__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="md"
                @click="active = ! active"
            ></component>

        </div>

        <input
            class="HeaderSearch__input"
            type="text"
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
        keywords: { default: '' }
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
