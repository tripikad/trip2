<template>
    <div class="TravelOfferListItem2">
        <div class="TravelOfferListItem" :class="isclasses">
            <div class="TravelOfferListItem__content">
                <div class="TravelOfferListItem__title">
                    {{item.name}}<span>al {{item.price}}€</span>
                </div>
                <div class="TravelOfferListItem__meta">
                    <div class="TravelOfferListItem__days">{{item.days}} päeva</div>
                    <div class="TravelOfferListItem__tag">
                        <tag :title="item.destinationName" isclasses="Tag--orange"/>
                    </div>
                    <div class="TravelOfferListItem__button">
                        <button-vue title="Muuda"
                                    isclasses="Button--small Button--blue"
                                    :route="item.editRoute"
                        />
                    </div>
                    <div class="TravelOfferListItem__button">
                        <button-vue title="Kustuta"
                                    isclasses="Button--small Button--pink"
                                    route="#"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="TravelOfferListItem2__stats">
            <div class="TravelOfferListItem2__inner_stats">
                <div class="TravelOfferListItem2__meta_row">Vaatamisi: 57</div>
                <div class="TravelOfferListItem2__meta_row">Päringuid: 6</div>
            </div>
        </div>
    </div>
</template>

<script>
import Tag from "../Tag/Tag.vue";
import ButtonVue from "../Button/ButtonVue.vue";
export default {
    components: {ButtonVue, Tag},
    props: {
        isclasses: { default: '' },
        item: { default: null },
        editRoute: { default: null },
    }
}
</script>