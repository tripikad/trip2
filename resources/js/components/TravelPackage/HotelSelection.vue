<template>
    <div class="TravelPackageHotelSelection" :class="isclasses">
        <table>
            <thead>
                <tr>
                    <th>Hotell</th>
                    <th>Toidlustus</th>
                    <th>Periood</th>
                    <th>Hind</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(hotel, index) in hotels">
                    <td>
                        <a :href="hotel.link" v-if="hotel.link" target="_blank">
                            {{hotel.name}}<span v-html="getRating(hotel.star)"/>
                        </a>
                        <template v-else>
                            {{hotel.name}}<span v-html="getRating(hotel.star)"/>
                        </template>
                    </td>
                    <td>{{hotel.accommodation}}</td>
                    <td>{{offer.nights}} ööd</td>
                    <td>al. <span class="TravelPackageHotelSelection__price">{{hotel.price}}€</span></td>
                    <td>
                        <button class="Button Button--orange">Päring</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        hotels: {
            type: Array,
            required: true
        },
        offer: {
            type: Object,
            required: true
        },

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
        },
    },
    methods: {
        getRating: function(rating) {
            if (!rating) {
                return ''
            } else {
                const stars = '*'.repeat(rating)
                return `<sub class="TravelPackageHotelSelection__rating">${stars}</sub>`
            }
        }
    }
}
</script>