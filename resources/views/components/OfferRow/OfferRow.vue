<template>
    <a :href="offer.route" class="OfferRow" :class="isclasses">
        <img class="OfferRow__image" :src="offer.image || './photos/image_blank.png'" />
        <div class="OfferRow__content">
            <div class="OfferRow__title">
                {{ offer.title }} al.
                <span class="OfferRow__price">{{ offer.price }}€</span>
            </div>
            <div class="OfferRow__meta">
                <tag :title="offer.end_destination.name" isclasses="Tag--white" />
                <div class="OfferRow__metaPrimary">{{ offer.duration_formatted }}</div>
                <div
                    class="OfferRow__metaSecondary"
                >{{ offer.start_at_formatted }} → {{ offer.end_at_formatted }}</div>
                <div v-if="offer.company" class="OfferRow__metaPrimary">{{ offer.user.name }}</div>
                <div v-if="offer.guide" class="OfferRow__metaSecondary">{{ offer.guide }}</div>
            </div>
        </div>
    </a>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        offer: { default: {} }
    }
}
</script>
