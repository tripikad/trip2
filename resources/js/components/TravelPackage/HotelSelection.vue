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
                        <label>Hotell</label>
                        <a :href="hotel.link" v-if="hotel.link" target="_blank">
                            {{hotel.name}}<span v-html="getRating(hotel.star)"/>
                        </a>
                        <template v-else>
                            {{hotel.name}}<span v-html="getRating(hotel.star)"/>
                        </template>
                    </td>
                    <td>
                        <label>Toidlustus</label>
                        {{hotel.accommodation}}
                    </td>
                    <td>
                        <label>Periood</label>
                        {{offer.nights}} ööd
                    </td>
                    <td>
                        <label>Hind</label>
                        <div class="TravelPackageHotelSelection__price_wrapper">
                            al.&nbsp;<span class="TravelPackageHotelSelection__price">{{hotel.price}}€</span>
                        </div>
                    </td>
                    <td>
                        <button class="Button Button--orange" @click="sendRequest(hotel)">Päring</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Modal
            v-model="showModal"
            title="Küsi pakkumist"
            modal-class="TravelPackageRequestModal"
            @before-open="beforeOpen"
            @before-close="beforeClose"
        >
            <RequestForm
                :offer="offer"
                :hotel="selectedHotel"
                :closeModal="closeModal"/>
        </Modal>

    </div>
</template>

<script>
import RequestForm from './RequestForm.vue'
import bodyScroll from 'body-scroll-freezer'
export default {
    components: {RequestForm},
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
    },
    data() {
        return {
            showModal: false,
            selectedHotel: {}
        }
    },
    computed: {
       /* getSelectedNightsValue: function() {
            return this.selectedNights ? parseInt(this.selectedNights) : null
        },*/
    },
    methods: {
        getRating: function(rating) {
            if (!rating) {
                return ''
            } else {
                const stars = '*'.repeat(rating)
                return `<sub class="TravelPackageHotelSelection__rating">${stars}</sub>`
            }
        },
        sendRequest: function (hotel) {
            this.selectedHotel = hotel
            this.showModal = true
        },
        closeModal: function () {
            this.showModal = false
            this.selectedHotel = {}
        },
        beforeOpen() {
            bodyScroll.freeze();
        },
        beforeClose() {
            bodyScroll.unfreeze();
        }
    },
    mounted() {
        bodyScroll.init();
    },
}
</script>