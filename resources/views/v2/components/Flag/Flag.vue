<template>

    <div
        class="Flag"
        :class="[isclasses, {'Flag--unflagged': ! currentFlagged}]"
        @click="toggleFlag"
    >

        <div class="Flag__icon">

            <component
                is="Icon"
                :icon="icon"
                size="sm"
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
        route: { default: '' },
        flagged: { default: '' },
        flagtitle: { default: '' },
        unflagtitle: { default: '' },
    },

    data: () => ({
        currentValue: 0,
        currentFlagged: null
    }),

    methods: {
        toggleFlag: function() {
            this.$http.get(this.route)
                .then(function(res) {
                    this.currentValue = res.data
                    this.currentFlagged = !this.currentFlagged
                    this.$events.$emit('alert', {
                        title: this.currentFlagged
                            ? this.flagtitle
                            : this.unflagtitle
                    })
                })
        }
    },

    mounted() {
        this.currentValue = this.value
        this.currentFlagged = (this.flagged === 'true')
    }
}

</script>
