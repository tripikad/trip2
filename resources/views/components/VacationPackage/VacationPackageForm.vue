<template>
    <form @submit.prevent="handleSubmit"
        class="VacationPackageForm"
        enctype="multipart/form-data"
        :class="isclasses"
        method="POST"
        autocomplete="off"
    >
        <div class="VacationPackageForm__subtitle">
            Üldinfo
        </div>

        <div class="VacationPackageForm__field">
            <text-field
                v-model="fields.name"
                name="name"
                title="Pakkumise nimetus"
                :errors="this.formatErrors()"/>
        </div>

        <div class="row VacationPackageForm__field">
            <div class="col-md-6 col-12">
                <form-datepicker
                    v-model="fields.startDate"
                    title="Algus"
                    name="startDate"
                    disable-past-dates="true"
                    :errors="this.formatErrors()"/>
            </div>
            <div class="col-md-6 col-12">
                <form-datepicker
                    v-model="fields.endDate"
                    title="Lõpp"
                    name="endDate"
                    disable-past-dates="true"
                    :errors="this.formatErrors()"/>
            </div>
        </div>

        <div class="row VacationPackageForm__field">
            <div class="col-md-6 col-12">
                <text-field
                    v-model="fields.price"
                    name="price"
                    title="Hind alates €"
                    :errors="this.formatErrors()"/>
            </div>
        </div>

        <div class="VacationPackageForm__field">
            <text-editor
                v-model="fields.description"
                title="Sisu"
                name="description"
                :errors="this.formatErrors()"/>
        </div>

        <div class="VacationPackageForm__field">
            <form-select-multiple
                name="category"
                title="Kategooria"
                v-model="fields.category"
                :options="categoryOptions"
                :errors="this.formatErrors()"/>
        </div>

        <div class="VacationPackageForm__field">
            <text-field
                v-model="fields.link"
                name="link"
                title="Link"
                placeholder="https://..."
                :errors="this.formatErrors()"/>
        </div>

        <div class="VacationPackageForm__subtitle">
            Pilt
        </div>

        <div>
            <ImageUpload
                name="image"
                :url="this.submitRoute"
                :autoUpload="false"/>
        </div>

        <div class="VacationPackageForm__submit-button">
            <submit-button :title="add ? 'Lisa' : 'Muuda'"/>
        </div>
    </form>

</template>

<script>

import TextField from "../Form/TextField.vue";
import SubmitButton from "../Form/SubmitButton.vue";
import FormSelectMultiple from "../FormSelectMultiple/FormSelectMultiple.vue";
import ImageUpload from "../ImageUpload/ImageUpload.vue";

export default {
    components: {ImageUpload, FormSelectMultiple, SubmitButton, TextField},
    props: {
        add: { default: true },
        isclasses: { default: '' },
        packageName: { default: '' },
        startDate: { default: null },
        endDate: { default: null },
        price: { default: '' },
        description: { default: '' },
        category: { default: () => [] },
        link: { default: '' },
        categoryOptions: { default: () => [] },
        image: { default: null },
        disabled: { default: false },
        submitRoute: null
    },
    data: function () {
        return {
            fields: {
                name: this.packageName,
                startDate: this.startDate,
                endDate: this.endDate,
                price: this.price,
                description: this.description,
                category: this.category,
                link: this.link,
                image: null,
                imageId: null
            },
            submitting: false,
            success: false,
            errors: [],
        }
    },
    methods: {
        formatErrors() {
            return Object.values(this.errors)
        },
        handleSubmit() {
            if (!this.submitting) {
                this.submitting = true;
                this.success = false;
                this.errors = {};

                const formData = new FormData();
                formData.append('name', this.fields.name);
                formData.append('startDate', this.fields.startDate);
                formData.append('endDate', this.fields.endDate);
                formData.append('price', this.fields.price);
                formData.append('description', this.fields.description);
                formData.append('category', JSON.stringify(this.fields.category));
                formData.append('link', this.fields.link);
                formData.append('image', this.fields.image);
                formData.append('imageId', this.fields.imageId);

                this.$http.post(this.submitRoute, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.submitting = false;
                    return window.location.href = response.data.route;
                }).catch(error => {
                    this.submitting = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.keys
                        const errorTitle =  error.response.data.errors.join('<br>')
                        this.$events.$emit('alert', {
                            title: errorTitle,
                            isType: 'error'
                        })
                    }
                });
            }
        },
    },
    mounted() {
        this.$events.$on('imageupload.success', file => {
            this.fields.image = file;
        })

        this.$events.$on('imageupload.remove_file', file => {
            this.fields.image = null;
        })
    }
};
</script>
