<template>
    <div class="company-edit-profile__form-container">
        <div class="VacationPackageForm__errors">
            <form-error-block
                :errors="errorBlockErrors"
                isclasses="VacationPackageForm__error-block"/>
        </div>
        <div class="company-edit-profile__form-container__form">
            <form class="VacationPackageForm"
                  ref="VacationPackageForm"
                  :action="submitRoute"
                  method="POST"
                  autocomplete="off"
            >
                <input type="hidden" name="_token" :value="csrf">

                <div class="row VacationPackageForm__field">
                    <div class="col-md-4 col-12">
                        <form-select
                            :value="destinationValue"
                            title="Sihtkoht"
                            name="destination"
                            :options="destinationOptions"
                            :errors=Object.keys(errors) />
                    </div>
                    <div class="col-md-4 col-12">
                        <form-datepicker
                            v-model="fields.startDate"
                            title="Algus"
                            name="start_date"
                            placeholder="Algus"
                            disable-past-dates="true"
                            :errors=errors.start_date />
                    </div>

                    <div class="col-md-4 col-12">
                        <form-datepicker
                            v-model="fields.endDate"
                            title="Lõpp"
                            name="end_date"
                            placeholder="lõpp"
                            disable-past-dates="true"
                            :errors=errors.end_date />
                    </div>
                </div>

                <div class="VacationPackageForm__subtitle">
                    Hotellid (max 5)
                </div>

                <div class="VacationPackageForm__hotels">
                    <travel-offer-hotel
                        :items="fields.hotels"
                        :accommodationOptions="accommodationOptions"
                        :errors="hotelErrors"/>
                </div>

                <div class="VacationPackageForm__subtitle">
                    Info
                </div>

                <div class="VacationPackageForm__tags">
                    <div class="VacationPackageForm__tag" v-for="(tag, index) in tags"
                         :class="{['VacationPackageForm__tag--active']: activeTab === tag.value}"
                         @click="setActiveTab(tag.value)">
                        {{tag.name}}
                    </div>
                </div>

                <div class="VacationPackageForm__field" v-for="(tag, index) in tags"
                     :class="{['VacationPackageForm__field--hidden']: activeTab !== tag.value}">
                    <form-text-editor
                        v-model="fields[tag.value]"
                        :name="tag.value"
                        class="VacationPackageForm__editor"/>
                </div>

                <div class="VacationPackageForm__buttons">
                    <div class="Button Button--large Button--gray VacationPackageForm__back-button" v-on:click="goBack()">
                        <div class="Button__title">Tagasi</div>
                    </div>
                    <div class="Button Button--large VacationPackageForm__submit-button" v-on:click="submitForm()">
                        <div class="Button__title">Salvesta</div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import FormDatepicker from "../FormDatepicker/FormDatepicker.vue";
import FormSelect from "../FormSelect/FormSelect.vue";
import Loading from "../Loading/Loading.vue";
import FormErrorBlock from "../FormErrorBlock/FormErrorBlock.vue";

export default {
    components: {FormErrorBlock, Loading, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        destinationOptions: { default: () => [] },
        accommodationOptions: { default: () => [] },
        add: { default: true },
        hotels: { default: () => [] },
        destination: { default: null },
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
            activeTab: 'description',
            tags: [
                {
                    name: 'Kirjeldus',
                    value: 'description'
                },
                {
                    name: 'Majutus',
                    value: 'accommodation'
                },
                {
                    name: 'Sisaldab',
                    value: 'included'
                },
                {
                    name: 'Ei sisalda',
                    value: 'excluded'
                },
                {
                    name: 'Lisatasu eest',
                    value: 'extra_fee'
                },
                {
                    name: 'Lisainfo',
                    value: 'extra_info'
                }
            ],
            fields: {
                destination: this.destination,
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
            this.$refs.VacationPackageForm.submit()
        },
        goBack: function () {
            window.location.href = this.backRoute
        }
    },
    computed: {
        destinationValue: function() {
            return this.fields.destination ? parseInt(this.fields.destination) : null
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