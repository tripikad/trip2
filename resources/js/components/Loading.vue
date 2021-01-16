<template>
    <div class="Loading">
        Loading
    </div>
</template>

<script>
export default {
    props: {
        show: { default: false }
    },

    data() {
        return {
            visible: this.show
        }
    },

    methods: {
        show: function() {

        },
    }
}
</script>
