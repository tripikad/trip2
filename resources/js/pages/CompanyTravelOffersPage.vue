<template>
    <div class="row page-company-travel-offers mr-0 ml-0">
        <div class="col-md-8 col-12">
            <TravelOfferList :items="offers"/>
        </div>
        <div class="col-md-4 col-12 mt-5 mt-md-0">
            <div>
                <AddNewSelect :company-id="company.id"/>
            </div>
            <div class="page-company-travel-offers__subscription">
                <SubscriptionPlan/>
            </div>
        </div>
    </div>
</template>

<script>
import TravelOfferList from '../components/CompanyTravelOfferList.vue'
import AddNewSelect from '../components/TravelOfferAddNewSelect.vue'
import SubscriptionPlan from '../components/TravelOfferSubscriptionPlan.vue'
export default {
    components: {TravelOfferList, AddNewSelect, SubscriptionPlan},
    props: {
        isclasses: { default: '' },
        company: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
            offers: this.company.travel_offers
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
    },
}
</script>