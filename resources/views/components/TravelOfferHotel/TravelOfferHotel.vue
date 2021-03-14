<template>
    <div class="TravelOfferHotel">
        <div class="FormTextfield margin-bottom-md TravelOfferHotel__container" v-for="(opt, index) in inputs">
            <div class="TravelOfferHotel__options">
                <div class="row">
                    <div class="col-sm-8 col-12">
                        <input
                            v-model="opt.name"
                            class="FormTextfield__input"
                            name="hotel[][name]"
                            type="text"
                            placeholder="Nimi (kohustuslik)">
                    </div>
                    <div class="col-sm-4 col-12">
                        <star-rating
                            v-model="opt.rating"
                            :show-rating="false"
                            :star-size="40"
                            :clearable="true"
                        />
                        <input type="hidden" name="hotel[][rating]" :value="opt.rating">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-12">
                        <input
                            v-model="opt.price"
                            class="FormTextfield__input"
                            name="hotel[][price]"
                            type="number"
                            placeholder="Hind (kohustuslik)">
                    </div>
                    <div class="col-sm-4 col-12">
                        <form-select name="hotel[][price]"
                                     :options="accValues"
                                     placeholder="Majutuse tüüp"
                                     isclasses="TravelOfferHotel__select"/>
                    </div>
                    <div class="col-sm-4 col-12">
                        <input
                            class="FormTextfield__input"
                            name="hotel[][link]"
                            type="text"
                            placeholder="Link">
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
import FormSelect from "../FormSelect/FormSelect.vue"
import StarRating from 'vue-star-rating'
export default {
    components: {FormSelect, StarRating},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
    },
    data() {
        return {
            inputs: [{
                id: 1,
                name: 'name1',
                rating: 2,
                price: 12,
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
        }
    },
    methods: {
        addField: function () {
            this.inputs.push({
                name: '',
                rating: 0,
                price: undefined,
            });
        },
        deleteField: function(index) {
            this.$delete(this.inputs, index);
        },
    },
}
</script>