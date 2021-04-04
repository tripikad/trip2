<template>
    <form class="TravelOfferSearch" :class="isclasses" id="TravelOfferSearch">
        <div class="TravelOfferSearch__content">
            <div class="TravelOfferSearch__field">
                <FormDatepicker
                    name="startDate"
                    isclasses="TravelOfferSearch__datepicker"
                    placeholder="Algus"
                    disablePastDates="true"/>
            </div>
            <div class="TravelOfferSearch__field">
                <FormDatepicker
                    name="endDate"
                    isclasses="TravelOfferSearch__datepicker"
                    placeholder="Lõpp"
                    disablePastDates="true"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="destination"
                    :options="destinations"
                    placeholder="Kõik sihtkohad"
                    isclasses="TravelOfferSearch__destination"/>
            </div>
            <div class="TravelOfferSearch__submit_btn">
                <form-button-process
                    title="Otsi"
                    id="TravelOfferSearch"
                    processingtitle="Otsin.."/>
            </div>
        </div>
    </form>
</template>

<script>
import FormDatepicker from "../FormDatepicker/FormDatepicker.vue";
import FormSelect from "../FormSelect/FormSelect.vue";
import FormSliderMultiple from "../FormSliderMultiple/FormSliderMultiple.vue";
import Loading from "../Loading/Loading.vue";
import FormButtonProcess from "../FormButtonProcess/FormButtonProcess.vue";
export default {
    components: {FormButtonProcess, Loading, FormSliderMultiple, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
    },
    data() {
        return {
            loading: false,
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