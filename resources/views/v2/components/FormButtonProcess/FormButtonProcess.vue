<template>

    <input
        class="FormButtonProcess"
        :class="isclasses"
        type="submit"
        :value="processing ? processingtitle : title"
        @click.once="onClick"
        :disabled="processing"
    >

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            title: { default: '' },
            processingtitle: { default: '' },
            id: { default: '' }
        },

        data: () => ({
            processing: false,
        }),

        methods: {
            onClick() {
                this.processing = true
                document.getElementById(this.id).submit()
            }
        }

    }

</script>
