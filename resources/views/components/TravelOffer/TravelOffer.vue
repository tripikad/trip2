<template>
    <div class="row">
        <div class="col-md-10 col-12 mx-auto">
            <travel-offer-search />
        </div>
        <div class="col-md-10 col-12 mx-auto">
            <div class="page-vp-index__filter">
                <form-select
                    name="filter"
                    :options="filters"
                    isclasses="page-vp-index__select"
                    :value="selectedValue"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
            <div class="page-vp-index__item">
                <travel-offer-list-item title="TENERIFE 26.02.2021"/>
            </div>
        </div>
    </div>
</template>

<script>
import FormDatepicker from "../FormDatepicker/FormDatepicker.vue";
import FormSelect from "../FormSelect/FormSelect.vue";
import FormSliderMultiple from "../FormSliderMultiple/FormSliderMultiple.vue";
export default {
    components: {FormSliderMultiple, FormSelect, FormDatepicker},
    props: {
        isclasses: { default: '' },
        options: { default: () => [] },
    },
    data() {
        return {
            selectedValue: 1,
            filters: [
                {
                    id: 1,
                    name: 'Sorteeri kuupäeva järgi'
                },
                {
                    id: 2,
                    name: 'Sorteeri hinna järgi'
                },
                {
                    id: 3,
                    name: 'Sorteeri kestvuse järgi'
                }
            ],
        }
    },
}
</script>