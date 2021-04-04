<template>
    <div class="TravelOfferAddNewSelect" :class="{[isclasses]: true }">
        <FormSelect name="selectedValue"
                    :options="addNewOptions"
                    placeholder="Lisa uus pakkumine"
                    isclasses="TravelOfferAddNewSelect__button"
                    v-model="value"/>
    </div>
</template>

<script>
import FormSelect from "../../../views/components/FormSelect/FormSelect.vue";
export default {
    components: {FormSelect},
    props: {
        isclasses: { default: '' },
        companyId: { default: undefined },
    },

    data() {
        return {
            companyIdValue: this.companyId,
            value: undefined,
            addNewOptions: [
                {
                    id: 'package',
                    name: 'Paketireis',
                },
                {
                    id: 'tour',
                    name: 'Ringreis'
                },
                {
                    id: 'ski',
                    name: 'Suusareis'
                }
            ],
        }
    },
    watch: {
        value(value) {
            window.location.href = '/company/' + this.companyIdValue + '/add_travel_offer?type=' + value
        }
    },
}
</script>
