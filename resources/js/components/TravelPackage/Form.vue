<template>
    <div class="TravelPackageForm">
        <div class="TravelPackageForm__errors">
            <form-error-block
                :errors="errorBlockErrors"
                isclasses="TravelPackageForm__error-block"/>
        </div>
        <div class="TravelPackageForm__form_container">
            <form ref="TravelPackageForm"
                  :action="submitRoute"
                  method="POST"
                  autocomplete="off"
            >
                <input type="hidden" name="_token" :value="csrf">

                <div class="row TravelPackageForm__field">
                    <div class="col-md-3 col-12">
                        <form-select
                            :value="startDestinationValue"
                            title="Algus sihtkoht"
                            name="start_destination"
                            :options="destinationOptions"
                            :errors=Object.keys(errors) />
                    </div>
                    <div class="col-md-3 col-12">
                        <form-select
                            :value="endDestinationValue"
                            title="Sihtkoht"
                            name="end_destination"
                            :options="destinationOptions"
                            :errors=Object.keys(errors) />
                    </div>
                    <div class="col-md-3 col-12">
                        <form-datepicker
                            v-model="fields.startDate"
                            title="Algus kuupäev"
                            name="start_date"
                            placeholder="Algus kp"
                            disable-past-dates="true"
                            :errors=errors.start_date />
                    </div>

                    <div class="col-md-3 col-12">
                        <form-datepicker
                            v-model="fields.endDate"
                            title="Lõpp kuupäev"
                            name="end_date"
                            placeholder="Lõpp kp"
                            disable-past-dates="true"
                            :errors=errors.end_date />
                    </div>
                </div>

                <div class="TravelPackageForm__subtitle">
                    Hotellid (max 5)
                </div>

                <div class="TravelPackageForm__hotels">
                    <travel-offer-hotel
                        :items="fields.hotels"
                        :accommodationOptions="accommodationOptions"
                        :errors="hotelErrors"/>
                </div>

                <div class="TravelPackageForm__subtitle">
                    Info
                </div>

                <div class="TravelPackageForm__tags">
                    <div class="TravelPackageForm__tag" v-for="(tag, index) in tags"
                         :class="{['TravelPackageForm__tag--active']: activeTab === tag.value}"
                         @click="setActiveTab(tag.value)">
                        {{tag.name}}
                    </div>
                </div>

                <div class="TravelPackageForm__field" v-for="(tag, index) in tags"
                     :class="{['TravelPackageForm__field--hidden']: activeTab !== tag.value}">
                    <form-text-editor
                        v-model="fields[tag.value]"
                        :name="tag.value"
                        :placeholder="tag.placeholder"
                        class="TravelPackageForm__editor"/>
                </div>

                <div class="TravelPackageForm__buttons">
                    <div class="Button Button--large Button--gray TravelPackageForm__back-button" v-on:click="goBack()">
                        <div class="Button__title">Tagasi</div>
                    </div>
                    <div class="Button Button--large TravelPackageForm__submit-button" v-on:click="submitForm()">
                        <div class="Button__title">Salvesta</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import FormDatepicker from "../../../views/components/FormDatepicker/FormDatepicker.vue";
import FormSelect from "../../../views/components/FormSelect/FormSelect.vue";
import Loading from "../../../views/components/Loading/Loading.vue";
import FormErrorBlock from "../../../views/components/FormErrorBlock/FormErrorBlock.vue";

export default {
    components: {FormErrorBlock, Loading, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        destinationOptions: { default: () => [] },
        accommodationOptions: { default: () => [] },
        add: { default: true },
        hotels: { default: () => [] },
        startDestination: { default: null },
        endDestination: { default: null },
        startDate: { default: null },
        endDate: { default: null },
        description: { default: null },
        accommodation: { default: null },
        included: { default: null },
        excluded: { default: null },
        extraFee: { default: null },
        extraInfo: { default: null },
        link: { default: null },
        disabled: { default: false },
        submitRoute: null,
        backRoute: null,
        errors: { default: () => [] },
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
            activeTab: 'included',
            tags: [
                /*{
                    name: 'Kirjeldus',
                    value: 'description'
                },
                {
                    name: 'Majutus',
                    value: 'accommodation'
                },*/
                {
                    name: 'Sisaldab',
                    value: 'included',
                    placeholder: 'Pakkumine sisaldab...'
                },
                {
                    name: 'Ei sisalda',
                    value: 'excluded',
                    placeholder: 'Pakkumine ei sisalda...'
                },
                {
                    name: 'Lisatasu eest',
                    value: 'extra_fee',
                    placeholder: 'Lisatasu eest...'
                },
                {
                    name: 'Lisainfo',
                    value: 'extra_info',
                    placeholder: 'Lisainfo...'
                }
            ],
            fields: {
                startDestination: this.startDestination,
                endDestination: this.endDestination,
                startDate: this.startDate,
                endDate: this.endDate,
                price: this.price,
                link: this.link,
                description: this.description,
                accommodation: this.accommodation,
                included: this.included,
                excluded: this.excluded,
                extraFee: this.extraFee,
                extraInfo: this.extraInfo,
                hotels: this.hotels,
            },
            hotelErrors: this.errors.hotels ? JSON.parse(this.errors.hotels) : []
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
        setActiveTab: function (tab) {
            this.activeTab = tab
        },
        submitForm: function () {
            this.$refs.TravelPackageForm.submit()
        },
        goBack: function () {
            window.location.href = this.backRoute
        }
    },
    computed: {
        startDestinationValue: function() {
            return this.fields.startDestination ? parseInt(this.fields.startDestination) : null
        },
        endDestinationValue: function() {
            return this.fields.endDestination ? parseInt(this.fields.endDestination) : null
        },
        errorBlockErrors: function() {
            return Object.keys(this.errors).reduce((object, key) => {
                if (key !== 'hotels') {
                    object[key] = this.errors[key]
                }
                return object
            }, {})
        }
    }
}
</script>