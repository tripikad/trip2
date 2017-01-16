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
            large: { default: '' },
            meta: { default: ''},
        },
        
        methods: {
            onClick() {
                this.$events.$emit('photo', {
                    large: this.large,
                    meta: this.meta,
                })
            }
        },

    }

</script>
