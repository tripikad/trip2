<template>

    <div class="PhotoCard" :class="isclasses">

        <img class="PhotoCard__photo" :src="small" @click="onClick" />

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            small: { default: '' },
            large: { default: '' }
        },
        
        methods: {
            onClick() {
                this.$events.$emit('photo', this.large)
            }
        }

    }

</script>
