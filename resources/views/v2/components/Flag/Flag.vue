<template>

    <div class="Flag" :class="[isclasses, {'Flag--red': flagged}]">

        <div class="Flag__icon">

            <component
                is="Icon"
                :icon="icon"
                size="sm"
                @click.native="toggleFlag"
            ></component>

        </div>

        <div class="Flag__value">{{ currentValue }}</div>

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

    data: () => ({
        currentValue: 0,
        flagged: false
    }),

    methods: {
        toggleFlag: function() {
            this.$http.get(this.route)
                .then(function(res) {
                    this.currentValue = res.data
                    this.flagged = ! this.flagged;
                })
        }
    },

    mounted() {
        this.currentValue = this.value
    }
}

</script>
