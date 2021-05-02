<template>
    <div class="TravelOfferListItem" :class="isclasses">
        <div class="TravelOfferListItem__content">
            <div class="TravelOfferListItem__title">
                <a :href="item.actionRoutes.show">
                    {{item.name}} <span class="from">al. </span><span class="price">{{item.price}}€</span>
                </a>
            </div>
            <div class="TravelOfferListItem__meta">
                <div class="TravelOfferListItem__days">{{item.nights}} ööd</div>
                <div class="TravelOfferListItem__tag">
                    <tag :title="item.end_destination.name" isclasses="Tag--orange"/>
                </div>
                <div class="TravelOfferListItem__tag">
                    <tag :title="item.company.name" :route="item.company.showRoute"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tag from '../../views/components/Tag/Tag.vue'
export default {
    components: {Tag},
    props: {
        isclasses: { default: '' },
        title: { default: '' },
        route: { default: '' },
        item: {
            type: Object,
            required: true
        },
    }
}
</script>