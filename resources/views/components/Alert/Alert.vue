<template>
    <div v-show="open" class="Alert" :class="{ 'Alert--error': type === 'error', [isclasses]: true }" transition="fadeCollapse" @click="onClick">
        <div class="Alert__title" v-html="title" />

        <div class="Alert__closeIcon">
            <component :is="'Icon'" icon="icon-close" size="md"></component>
        </div>
    </div>
</template>

<script>
import Icon from '../Icon/Icon.vue'

export default {
    components: { Icon },

    props: {
        isclasses: { default: '' },
        isType: { default: 'success'}
    },

    data() {
        return {
            open: false,
            title: '',
            type: 'success',
            timeout: 3000
        }
    },

    methods: {
        onClick() {
            this.open = false
        }
    },

    mounted() {
        this.$events.$on('alert', alert => {
            this.title = alert.title
            this.type = alert.isType
            this.open = true
            setTimeout(() => (this.open = false), alert.isType === 'error' ? 5000 : 3000)
        })
    }
}
</script>
