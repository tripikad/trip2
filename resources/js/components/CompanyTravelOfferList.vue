<template>
    <div class="CompanyTravelOfferList" :class="isclasses">
        <div class="CompanyTravelOfferList__item_wrapper" v-for="(item, index) in items">
            <div class="CompanyTravelOfferList__item">
                <TravelOfferListItem :item="item"/>
            </div>
            <div class="CompanyTravelOfferList__stats">
                <div class="CompanyTravelOfferList__stats__content">
                    <div class="CompanyTravelOfferList__meta_row">Vaatamisi: {{item.views ? item.views.count : 0}}</div>
                    <div class="CompanyTravelOfferList__meta_row">Päringuid: 6</div>
                </div>
                <div class="CompanyTravelOfferList__buttons">
                    <div class="TravelOfferListItem__button">
                        <button-vue title="Muuda"
                                    isclasses="Button--small Button--blue"
                                    :route="item.actionRoutes.edit"
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
    </div>
</template>

<script>
import TravelOfferListItem from './TravelOfferListItem.vue'
import ButtonVue from '../../views/components/Button/ButtonVue.vue'
export default {
    components: {ButtonVue, TravelOfferListItem},
    props: {
        isclasses: { default: '' },
        items: { default: () => [] },
    }
}
</script>