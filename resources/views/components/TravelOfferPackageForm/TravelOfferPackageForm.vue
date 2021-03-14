<template>
    <div class="company-edit-profile__form-container">
        <div class="company-edit-profile__form-container__form">
            <form class="VacationPackageForm"
                  action=""
                  method="POST"
                  autocomplete="off"
            >
                <input type="hidden" name="_token" :value="csrf">

                <div class="VacationPackageForm__field">
                    <form-select
                        v-model="fields.destination"
                        title="Sihtkoht"
                        name="destination"
                        :options="destinations"/>
                </div>

                <div class="row VacationPackageForm__field">
                    <div class="col-md-6 col-12">
                        <form-datepicker
                            v-model="fields.startDate"
                            title="Algus"
                            name="start_date"
                            placeholder="Algus"
                            disable-past-dates="true"
                            errors="">
                        </form-datepicker>
                    </div>

                    <div class="col-md-6 col-12">
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

                <div class="VacationPackageForm__field">
                    <form-text-editor
                        v-model="fields.description"
                        title="Kirjeldus"
                        name="description"
                        class="VacationPackageForm__editor"
                        errors="">
                    </form-text-editor>
                </div>

                <div class="VacationPackageForm__field">
                    <form-text-editor
                        v-model="fields.accommodation"
                        title="Majutuse info"
                        name="accommodation"
                        errors="">
                    </form-text-editor>
                </div>

                <div class="VacationPackageForm__field">
                    <form-text-editor
                        v-model="fields.included"
                        title="Pakkumine sisaldab"
                        name="included"
                        errors="">
                    </form-text-editor>
                </div>

<!--                <div class="VacationPackageForm__field">
                    <form-text-editor
                        title="Pakkumine ei sisalda"
                        name="description"
                        value="{{ old('description') }}"
                        errors="">
                    </form-text-editor>
                </div>

                <div class="VacationPackageForm__field">
                    <form-text-editor
                        title="Lisatasu eest"
                        name="description"
                        errors="">
                    </form-text-editor>
                </div>

                <div class="VacationPackageForm__field">
                    <form-text-editor
                        title="Lisainfo"
                        name="description"
                        errors="">
                    </form-text-editor>
                </div>-->

                <div class="VacationPackageForm__submit-button">
                    <button type="button" title="Lisa"/>
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
    },
}
</script>