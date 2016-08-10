<template>

    <div class="SearchSmall" :class="isclasses">

        <div class="SearchSmall__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="md"
                @click="showField = true"
            ></component>

        </div>

        <div class="SearchSmall__field" v-if="showField" @keyup.enter="Search()">

            <input type="text" v-model="search"></input

        </div>

    </div>

</template>

<script>

import Icon from '../Icon/Icon.vue'

export default {

    components: {
        Icon
    },

    props: {
        isclasses: { default: '' },
        showField: false,
        search: { default: '' }
    },

    methods: {
        Search: function() {
            window.location = './search?q=' + this.search
        }
    }

}

</script>
