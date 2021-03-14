<template>
    <div class="TravelOfferSearch" :class="isclasses">
        <div class="TravelOfferSearch__tags">
            <div class="TravelOfferSearch__tag TravelOfferSearch__tag--active">
                Kõik
            </div>
            <div class="TravelOfferSearch__tag" v-on:click="setLoading()">
                Puhkusepaketid
                <svg>
                    <use xlink:href="#palm-tree"></use>
                </svg>
            </div>
            <div class="TravelOfferSearch__tag">
                Ringreis
                <svg>
                    <use xlink:href="#baggage"></use>
                </svg>
            </div>
            <div class="TravelOfferSearch__tag">
                Suusareis
                <svg>
                    <use xlink:href="#luggage"></use>
                </svg>
            </div>
            <div class="TravelOfferSearch__tag TravelOfferSearch__last_minute">
                Viimase hetke pakkumised
                <svg>
                    <use xlink:href="#palm-tree"></use>
                </svg>
            </div>
        </div>
        <div class="TravelOfferSearch__content">
            <div class="TravelOfferSearch__field">
                <FormDatepicker name="startDate" isclasses="TravelOfferSearch__datepicker" placeholder="Algus"/>
            </div>
            <div class="TravelOfferSearch__field">
                <FormDatepicker name="endDate" isclasses="TravelOfferSearch__datepicker" placeholder="Lõpp"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect name="destination" :options="destinations" placeholder="Kõik sihtkohad" isclasses="TravelOfferSearch__destination"/>
            </div>
<!--            <div class="TravelOfferSearch__field TravelOfferSearch__price">
                <FormSliderMultiple isclasses="TravelOfferSearch__slider" :step="step" :max=maxPrice :value2="value2" suffix="€"/>
            </div>-->
        </div>
    </div>
</template>

<script>
import FormDatepicker from "../FormDatepicker/FormDatepicker.vue";
import FormSelect from "../FormSelect/FormSelect.vue";
import FormSliderMultiple from "../FormSliderMultiple/FormSliderMultiple.vue";
import Loading from "../Loading/Loading.vue";
export default {
    components: {Loading, FormSliderMultiple, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
    },
    data() {
        return {
            loading: false,
            maxPrice: 1500,
            value2: 1500,
            step: 10,
            suffix: '€',
            destinations: [
                {
                    id: 1,
                    name: 'Eesti'
                },
                {
                    id: 2,
                    name: 'Tai'
                },
                {
                    id: 3,
                    name: 'Türgi'
                }
            ],
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
    },
}
</script>