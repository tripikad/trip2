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
import FormButtonProcess from "../../../views/components/FormButtonProcess/FormButtonProcess.vue";
import FormSelectWithGroup from "../FormSelectWithGroup.vue";
export default {
    components: {FormSelectWithGroup, FormButtonProcess, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
        startDestinations: { default: () => [] },
        endDestinations: { default: () => [] },
        selectedStartDestination: { default: '' },
        selectedEndDestination: { default: '' },
        selectedStartDate2: { default: '' },
        selectedNights: { default: '' },
    },
    data() {
        return {
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
}
</script>