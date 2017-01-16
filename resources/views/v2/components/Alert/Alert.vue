<template>

    <div
        v-show="open"
        class="Alert"
        :class="isclasses"
        transition="fadeCollapse"
        @click="onClick"
    >
            
        <div class="Alert__title">

            {{ title }}

        </div>

        <div
            class="Alert__closeIcon"
        >

            <component
                is="Icon"
                icon="icon-close"
                size="md"
            >
            </component>

        </div>

    </div>

</template>

<script>

    import Icon from '../Icon/Icon.vue'

    export default {

        components: { Icon },

        props: {
            isclasses: { default: '' },
        },

        data() {
            return {
                open: false,
                title: ''
            }
        },

        methods: {
            onClick() {
                this.open = false
            }
        },

        mounted() {
            this.$events.$on('alert', (alert) => {
                this.title = alert.title
                this.open = true
                setTimeout(() => this.open = false, 1400)
            })
        }

    }

</script>
