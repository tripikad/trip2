<template>
    <a :href="route" class="OfferRow" :class="isclasses" :dusk="slugTitle">
        <img class="OfferRow__image" :src="offer.image || './photos/image_blank.png'" />
        <div class="OfferRow__content">
            <div class="OfferRow__title">
                {{ offer.title }}
                <span class="OfferRow__price">{{ offer.price_formatted }}</span>
            </div>
            <div class="OfferRow__meta">
                <tag
                    v-for="(destination, i) in offer.end_destinations.slice(0, 1)"
                    :key="i"
                    :title="destination.name"
                    isclasses="Tag--white"
                />
                <div class="OfferRow__metaPrimary">{{ offer.duration_formatted }}</div>
                <div class="OfferRow__metaSecondary">{{ offer.start_at_formatted }} → {{ offer.end_at_formatted }}</div>
                <div v-if="offer.user.name" class="OfferRow__metaPrimary">{{ offer.user.name }}</div>
            </div>
        </div>
    </a>
</template>

<script>
import { slug } from '../../utils/utils'

export default {
    props: {
        isclasses: { default: '' },
        offer: { default: {} },
        route: { default: '' }
    },
    computed: {
        slugTitle() {
            return this.offer.title ? slug(this.offer.title) : ''
        }
    }
}
</script>
