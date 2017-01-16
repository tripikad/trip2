<template>
        
    <div
        class="Alert"
        :class="isclasses"
        v-show="show"
        transition="fadeCollapse"
    >

        <div class="Alert__title">
            
            {{ title }}
        
        </div>

        <div class="Alert__close" @click="show = false">
            
            <component is="Icon" icon="icon-close"></component>
        
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
        title: { default: '' }
    },

    data() {
        return {
            show: false
        }
    },

    mounted() {
        this.$events.$on('showAlert', function(alert) {
            this.title = alert
            this.show = true
            setTimeout(function() {
                this.show = false
            }.bind(this), 2000)
        })
    }

}

</script>