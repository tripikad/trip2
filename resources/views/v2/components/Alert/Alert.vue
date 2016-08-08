<template>
        
    <div
        class="Alert"
        :class="isclasses"
        v-show="show"
        transition="fadeCollapse"
    >

        <div class="Alert__title">
            {{ alert }}
        </div>

        <div class="Alert__close" @click="show = false">
            <component is="Icon" name="icon-close"></component>
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
        alert: { default: '' }
    },

    data() {
        return {
            show: false
        }
    },

    events: {
        'showAlert': function(alert) {
            this.alert = alert
            this.show = true
            setTimeout(function() {
                this.show = false
            }.bind(this), 2000)
        }
    }

}

</script>