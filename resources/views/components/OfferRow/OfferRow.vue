<template>
    <a :href="offer.route" class="OfferRow" :class="isclasses">
        <img class="OfferRow__image" :src="offer.image || './photos/image_blank.png'" />
        <div>
            <div class="OfferRow__title">{{ offer.title }} al. {{ offer.price }}</div>
            <div class="OfferRow__meta">{{ meta.join(' ') }}</div>
        </div>
    </a>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        offer: { default: {} }
    },
    computed: {
        meta() {
            return Object.entries(this.offer)
                .filter(
                    ([key]) =>
                        !['title', 'image', 'price', 'route'].includes(key)
                )
                .map(([key, value]) => value)
        }
    }
}
</script>
