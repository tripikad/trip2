<template>

    <div class="Flag" :class="isclasses">

        <div class="Flag__icon">

            <component
                is="Icon"
                :icon="icon"
                size="sm"
                @click="toggleFlag"
            ></component>

        </div>

        <div class="Flag__value">{{ value }}</div>

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
        icon: { default: '' },
        value: { default: 0 },
        route: { default: '' }
    },

    methods: {
        toggleFlag: function() {
            this.$http.post(this.route, { value: this.value })
                .then(function(res) {
                    this.value = res.data.value
                })
        }
    }
}

</script>
