<template>
    <div class="TravelOfferListItem" :class="isclasses">
        <div class="TravelOfferListItem__image">
            <svg>
                <use xlink:href="#palm-tree"></use>
            </svg>
        </div>
        <div class="TravelOfferListItem__content">
            <div class="TravelOfferListItem__title">
                {{title}}<span>al 499€</span>
            </div>
            <div class="TravelOfferListItem__meta">
                <div class="TravelOfferListItem__days">7 päeva</div>
                <div class="TravelOfferListItem__tag">
                    <tag title="Hispaania" isclasses="Tag--orange"/>
                </div>
                <div class="TravelOfferListItem__tag">
                    <tag title="TestFirma"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tag from "../Tag/Tag.vue";
export default {
    components: {Tag},
    props: {
        isclasses: { default: '' },
        title: { default: '' },
        route: { default: '' }
    }
}
</script>