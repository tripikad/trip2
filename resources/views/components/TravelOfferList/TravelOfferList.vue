<template>
    <div class="TravelOfferList" :class="isclasses">
        <div v-for="(item, index) in items">
            <travel-offer-list-item2
                :item="item"/>
        </div>
    </div>
</template>

<script>
import TravelOfferListItem2 from "../TravelOfferListItem2/TravelOfferListItem2.vue";
export default {
    components: {TravelOfferListItem2},
    props: {
        isclasses: { default: '' },
        items: { default: () => [] },
    }
}
</script>