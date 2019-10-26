<template>
    <div v-if="show" class="OfferDetails" :class="isclasses">
        <div style="display: flex; justify-content: flex-end; cursor: pointer;">
            <icon icon="icon-close" size="lg" class="Icon--darkGray" @click.native="show = false" />
        </div>
        <pre style="overflow: auto">{{ offer }}</pre>
        <br />
        <button-vue title="Broneeri reis" />
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' }
    },
    data: () => ({
        offer: '',
        show: false
    }),
    mounted() {
        this.$events.$on('offer', offer => {
            this.offer = offer
            this.show = true
        })
    }
}
</script>
