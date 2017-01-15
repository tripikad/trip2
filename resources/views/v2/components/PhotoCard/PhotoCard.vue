<template>

    <div class="PhotoCard" :class="isclasses">

        <div class="PhotoCard__photo">

            <img :src="small" @click="onClick" />

        </div>

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
