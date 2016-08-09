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

        <div class="Flag__value">{{ innerValue }}</div>

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

    data: function() {
        return {
            innerValue: 0
        }
    },

    ready() {
        this.innerValue = this.value
    },

    methods: {
        toggleFlag: function() {
            this.$http.post(this.route, { value: this.innerValue })
                .then(function(res) {
                    this.innerValue = res.data.value
                })
        }
    }
}

</script>
