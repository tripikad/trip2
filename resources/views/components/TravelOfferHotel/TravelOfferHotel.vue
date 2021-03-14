<template>
    <div class="TravelOfferHotel">
        <div class="FormTextfield margin-bottom-md TravelOfferHotel__container" v-for="(opt, index) in inputs">
            <div class="TravelOfferHotel__options">
                <input
                    class="FormTextfield__input"
                    :name="'item[]'"
                    type="text"
                    placeholder="Nimi (kohustuslik)">


                <div class="row">
                    <div class="col-6">
                        <input
                            class="FormTextfield__input"
                            :name="'item2[]'"
                            type="number"
                            placeholder="Hind (kohustuslik)">
                    </div>
                    <div class="col-6">
                        <form-select name="acc"
                                     :options="stars"
                                     placeholder="Tärnid"
                                     isclasses="TravelOfferHotel__select"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <input
                            class="FormTextfield__input"
                            :name="'item2[]'"
                            type="text"
                            placeholder="Link">
                    </div>
                    <div class="col-6">
                        <form-select name="acc"
                                     :options="accValues"
                                     placeholder="Majutuse tüüp"
                                     isclasses="TravelOfferHotel__select"/>
                    </div>
                </div>
            </div>
            <div>
                <a class="PollOption__delete" v-on:click="deleteField(index)">
                    <component
                        is="Icon"
                        isclasses="white"
                        icon="icon-trash"
                        size="lg"/>
                </a>
            </div>
        </div>
        <button class="TravelOfferHotel__new_hotel" v-on:click="addField" type="button">
            Lisa uus hotell
        </button>
    </div>
</template>

<script>
import FormSelect from "../FormSelect/FormSelect.vue";
export default {
    components: {FormSelect},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
    },
    data() {
        return {
            selectedValue: 1,
            stars: [{
                id: '-1',
                name: 'Määramata'
            },
            {
                id: 1,
                name: '1'
            },
            {
                id: 2,
                name: '2'
            },
            {
                id: 3,
                name: '3'
            },
            {
                id: 4,
                name: '4'
            },
            {
                id: 5,
                name: '5'
            }],
            accValues: [
            {
                id: '-1',
                name: 'Määramata'
            },
            {
                id: 1,
                name: 'All inclusive (AI)'
            },
            {
                id: 2,
                name: 'Täispansion (FB)'
            },
            {
                id: 3,
                name: 'Poolpansion (HB)'
            },
            {
                id: 4,
                name: 'Bed & Breakfast (BB)'
            },
            {
                id: 5,
                name: 'Ilma toitlustuseta (BO)'
            }],
            inputs: [{
                id: 1,
                value: 'value1'
            }]
        }
    },
    methods: {
        addField: function () {
            this.inputs.push({
                value: ''
            });
        },
        deleteField: function(index) {
            this.$delete(this.inputs, index);
        },
    },
}
</script>