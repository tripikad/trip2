<template>

    <div class="SearchSmall" :class="isclasses">

        <div class="SearchSmall__icon">

            <component
                is="Icon"
                icon="icon-search"
                size="md"
                @click="ShowField = true"
            ></component>

        </div>

        <div class="SearchSmall__field" v-if="ShowField" @keyup.enter="Search()">

            <input type="text">{{ search }}</input

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
            ShowField: false,
            search: { default: '' }
        },

        methods: {
            Search: function (search) {
                window.location('./search/q='+search);
            }
        }

    }

</script>
