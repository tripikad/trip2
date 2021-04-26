<template>
    <div class="TravelPackageRequestForm">
        <div class="TravelPackageRequestForm__content">
<!--            <div class="TravelPackageRequestForm__errors">
                <FormErrorBlock
                    :errors="errors"
                    isclasses="TravelPackageForm__error-block"/>
            </div>-->
            <form ref="TravelPackageRequestForm2"
                  action="#"
                  method="POST"
                  autocomplete="off"
            >
                <input type="hidden" name="_token" :value="csrf">

                <div class="row TravelPackageRequestForm__field">
                    <div class="col-12">
                        <FormTextField
                            v-model="name"
                            title="Nimi"
                            type="text"
                            name="name"/>
                    </div>
                </div>
                <div class="row TravelPackageRequestForm__field">
                    <div class="col-12">
                        <FormTextField
                            v-model="email"
                            title="E-mail"
                            type="text"
                            name="name"/>
                    </div>
                </div>
                <div class="row TravelPackageRequestForm__field">
                    <div class="col-12">
                        <FormTextField
                            v-model="phone"
                            title="Telefon"
                            type="text"
                            name="phone"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12 TravelPackageRequestForm__field">
                        <FormTextField
                            v-model="adults"
                            title="Täiskasvanuid"
                            type="number"
                            name="phone"/>
                    </div>
                    <div class="col-md-6 col-12 TravelPackageRequestForm__field">
                        <FormTextField
                            v-model="children"
                            title="Lapsi"
                            type="number"
                            name="phone"/>
                    </div>
                </div>
                <div class="row TravelPackageRequestForm__field">
                    <div class="col-12">
                        <FormTextarea
                            v-model="info"
                            title="Lisainfo"
                            name="info"/>
                    </div>
                </div>
                <div class="row TravelPackageRequestForm__field">
                    <div class="col-12">
                        <FormCheckbox
                            v-model="flexibleDates"
                            title="Olen paindlik kuupäevade osas (+/-3 päeva)"
                            name="flexible_dates"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="row TravelPackageRequestForm__footer">
            <div class="TravelPackageRequestForm__buttons">
                <div class="Button Button--gray TravelPackageRequestForm__back-button" v-on:click="close()">
                    <div class="Button__title">Katkesta</div>
                </div>
                <div class="Button TravelPackageRequestForm__submit-button" v-on:click="submitForm()">
                    <div class="Button__title">Saada</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormErrorBlock from "../../../views/components/FormErrorBlock/FormErrorBlock.vue";
import FormTextField from "../../../views/components/FormTextfield/FormTextField.vue";
import FormTextarea from "../../../views/components/FormTextarea/FormTextarea.vue";
import FormCheckbox from "../../../views/components/FormCheckbox/FormCheckbox.vue";
export default {
    components: {FormCheckbox, FormTextarea, FormTextField, FormErrorBlock},
    props: {
        offer: {
            type: Object,
            required: true
        },
        hotel: {
            type: Object,
            required: true
        },
        closeModal: {
            type: Function,
            required: true
        }
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            loading: false,
            errors: [],
            name: null,
            email: null,
            phone: null,
            startDate: null,
            endDate: null,
            info: null,
            flexibleDates: false,
            adults: 2,
            children: 0
        }
    },
    methods: {
        setLoading: function () {
            this.loading = !this.loading
        },
        submitForm: function () {
            this.close()
            //this.$refs.TravelPackageForm.submit()
        },
        close: function () {
            this.closeModal()
        }
    },
    watch: {
        /*showModal: function (show) {
            this.showModal = show
        },*/
    }
}
</script>