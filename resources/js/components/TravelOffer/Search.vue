<template>
    <form class="TravelOfferSearch" :class="isclasses" id="TravelOfferSearchForm">
        <div class="TravelOfferSearch__content">
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="start_destination"
                    :options="destinations"
                    placeholder="Algus sihtkoht"
                    isclasses="TravelOfferSearch__destination"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="end_destination"
                    :options="destinations"
                    placeholder="Kõik sihtkohad"
                    isclasses="TravelOfferSearch__destination"/>
            </div>
            <div class="TravelOfferSearch__field">
                <FormDatepicker
                    name="startDate"
                    isclasses="TravelOfferSearch__datepicker"
                    placeholder="Algus kp"
                    disablePastDates="true"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="nights"
                    :options="nights"
                    placeholder="Ööde arv"
                    isclasses="TravelOfferSearch__destination"/>
            </div>
            <div class="TravelOfferSearch__submit_btn">
                <form-button-process
                    title="Otsi"
                    id="TravelOfferSearchForm"
                    processingtitle="Otsin..."/>
            </div>
        </div>
    </form>
</template>

<script>
import FormDatepicker from "../../../views/components/FormDatepicker/FormDatepicker.vue";
import FormSelect from "../../../views/components/FormSelect/FormSelect.vue";
import FormSliderMultiple from "../../../views/components/FormSliderMultiple/FormSliderMultiple.vue";
import FormButtonProcess from "../../../views/components/FormButtonProcess/FormButtonProcess.vue";
export default {
    components: {FormButtonProcess, FormSliderMultiple, FormSelect, FormDatepicker},
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
            nights: [
                {
                    id: 1,
                    name: '5 ööd'
                },
                {
                    id: 2,
                    name: '7 ööd'
                },
                {
                    id: 3,
                    name: '8 ööd'
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