<template>
    <div class="TravelOfferHotel">
        <div class="FormTextfield margin-bottom-md TravelOfferHotel__container" v-for="(hotel, index) in hotels">
            <div class="TravelOfferHotel__options">
                <div class="row">
                    <div class="col-sm-8 col-12">
                        <form-text-field
                            v-model="hotel.name"
                            :name="'hotel[' + index + '][name]'"
                            placeholder="Nimi (kohustuslik)"
                            :errors="getErrors(index, 'name')"
                        />
                    </div>
                    <div class="col-sm-4 col-12">
                        <star-rating
                            v-model="hotel.star"
                            :show-rating="false"
                            :star-size="40"
                            :clearable="true"
                            class="TravelOfferHotel__rating"
                        />
                        <input type="hidden" :name="'hotel[' + index + '][star]'" :value="hotel.star">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-12">
                        <form-text-field
                            v-model="hotel.price"
                            :name="'hotel[' + index + '][price]'"
                            type="number"
                            placeholder="Hind (kohustuslik)"
                            :errors="getErrors(index, 'price')"
                        />
                    </div>
                    <div class="col-sm-4 col-12">
                        <form-select
                             v-model="hotel.accommodation"
                             :name="'hotel[' + index + '][accommodation]'"
                             :options="accommodationOptions"
                             placeholder="Majutuse tüüp"
                             isclasses="TravelOfferHotel__select"/>
                    </div>
                    <div class="col-sm-4 col-12">
                        <input
                            v-model="hotel.link"
                            class="FormTextfield__input"
                            :name="'hotel[' + index + '][link]'"
                            type="text"
                            placeholder="Link">
                    </div>
                </div>
            </div>
            <div>
                <a class="TravelOfferHotel__delete-btn" v-on:click="deleteHotel(index)" v-if="hotels.length > 1">
                    <component
                        is="Icon"
                        isclasses="white"
                        icon="icon-trash"
                        size="lg"/>
                </a>
            </div>
        </div>
        <button class="TravelOfferHotel__new_hotel" v-on:click="addHotel" type="button" v-if="this.canAddHotels()">
            Lisa uus hotell
        </button>
    </div>
</template>

<script>
import FormSelect from "../FormSelect/FormSelect.vue"
import StarRating from 'vue-star-rating'
import FormTextField from "../FormTextfield/FormTextField.vue";
export default {
    components: {FormTextField, FormSelect, StarRating},
    props: {
        isclasses: { default: '' },
        accommodationOptions: { default: () => [] },
        items: { default: () => [] },
        maxHotels: { type: Number, default: 5 },
        errors: { default: () => [] },
    },
    data() {
        return {
            hotels: this.items
        }
    },
    methods: {
        addHotel: function () {
            if (this.canAddHotels()) {
                this.hotels.push({
                    name: '',
                    star: 0,
                    price: undefined,
                });
            }
        },
        deleteHotel: function(index) {
            this.$delete(this.hotels, index)
        },
        canAddHotels: function() {
            return this.hotels.length < this.maxHotels
        },
        getErrors: function (index, name) {
            return (this.errors && this.errors[index] && this.errors[index][name]) ? this.errors[index][name] : []
        }
    },
    mounted() {
        if (!this.hotels.length) {
            this.addHotel()
        }
    }
}
</script>