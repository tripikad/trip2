<template>
    <form class="TravelOfferSearch" :class="isclasses" id="TravelOfferSearchForm">
        <div class="TravelOfferSearch__content">
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="start_destination"
                    :options="startDestinations"
                    :value="selectedStartDestination"
                    placeholder="Algus sihtkoht"
                    isclasses="TravelOfferSearch__destination"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelectWithGroup
                    name="end_destination"
                    :options="endDestinations"
                    :value="selectedEndDestination"
                    placeholder="Kõik sihtkohad"
                    isclasses="TravelOfferSearch__destination"
                />
            </div>
            <div class="TravelOfferSearch__field">
                <FormDatepicker
                    name="start_date"
                    isclasses="TravelOfferSearch__datepicker"
                    placeholder="Algus kp"
                    :value="selectedStartDate"
                    disablePastDates="true"/>
            </div>
            <div class="TravelOfferSearch__field TravelOfferSearch__destination_field">
                <FormSelect
                    name="nights"
                    :options="nights"
                    :value="getSelectedNightsValue"
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
import FormButtonProcess from "../../../views/components/FormButtonProcess/FormButtonProcess.vue";
import FormSelectWithGroup from "../FormSelectWithGroup.vue";
export default {
    components: {FormSelectWithGroup, FormButtonProcess, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
        startDestinations: { default: () => [] },
        endDestinations: { default: () => [] },
        nights: { default: () => [] },
        selectedStartDestination: { default: '' },
        selectedEndDestination: { default: '' },
        selectedNights: { default: null },
        selectedStartDate: { default: null }
    },
    data() {
        return {

        }
    },
    computed: {
        getSelectedNightsValue: function() {
            return this.selectedNights ? parseInt(this.selectedNights) : null
        }
    }
}
</script>