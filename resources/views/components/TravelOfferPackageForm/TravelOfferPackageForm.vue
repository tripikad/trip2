<template>
    <div class="company-edit-profile__form-container">
        <div class="company-edit-profile__form-container__form">
            <form class="VacationPackageForm"
                  action=""
                  method="POST"
                  autocomplete="off"
            >
                <input type="hidden" name="_token" :value="csrf">

                <div class="row VacationPackageForm__field">
                    <div class="col-md-4 col-12">
                        <form-select
                            v-model="fields.destination"
                            title="Sihtkoht"
                            name="destination"
                            :options="destinations"
                            errors=""/>
                    </div>
                    <div class="col-md-4 col-12">
                        <form-datepicker
                            v-model="fields.startDate"
                            title="Algus"
                            name="start_date"
                            placeholder="Algus"
                            disable-past-dates="true"
                            errors="">
                        </form-datepicker>
                    </div>

                    <div class="col-md-4 col-12">
                        <form-datepicker
                            v-model="fields.endDate"
                            title="Lõpp"
                            name="end_date"
                            placeholder="lõpp"
                            disable-past-dates="true"
                            errors="">
                        </form-datepicker>
                    </div>
                </div>

                <div class="VacationPackageForm__subtitle">
                    Hotellid
                </div>

                <div class="VacationPackageForm__hotels">
                    <travel-offer-hotel />
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
                    <div class="Button Button--large Button--gray VacationPackageForm__back-button">
                        <div class="Button__title">Tagasi</div>
                    </div>
                    <div class="Button Button--large VacationPackageForm__submit-button">
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
export default {
    components: {Loading, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
        add: { default: true },
        destination: { default: null },
        startDate: { default: null },
        endDate: { default: null },
        description: { default: '' },
        accommodation: { default: null },
        included: { default: '' },
        category: { default: () => [] },
        link: { default: '' },
        categoryOptions: { default: () => [] },
        image: { default: null },
        disabled: { default: false },
        submitRoute: null
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            activeTab: 'description',
            loading: false,
            destinations: [
                {
                    id: 1,
                    name: 'Eesti'
                },
                {
                    id: 2,
                    name: 'Tai'
                },
                {
                    id: 3,
                    name: 'Türgi'
                }
            ],
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
                description: this.description,
                category: this.category,
                link: this.link,
                image: null,
                imageId: null
            },
            errors: [],
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
        setActiveTab: function (tab) {
            this.activeTab = tab
        }
    },
}
</script>