<template>
    <div class="OfferList" :class="isclasses">
        <dotmap :largedots="filteredOfferList.map(o => o.coordinates)" />
        <form-slider-multiple
            isclasses="FormSliderMultiple--yellow"
            :value="activePriceFrom"
            @input="value => (activePriceFrom = value)"
            :value2="activePriceTo"
            @input2="value2 => (activePriceTo = value2)"
            :min="minPrice"
            :max="maxPrice"
            :step="step"
            suffix="€"
        />
        <div class="OfferList__filters">
            <form-select :options="styles" v-model="activeStyle" isclasses="FormSelect--blue" />
            <form-select
                :options="destinations"
                v-model="activeDestination"
                isclasses="FormSelect--blue"
            />
            <form-select :options="companies" v-model="activeCompany" isclasses="FormSelect--blue" />
            <a :style="{opacity: !notFiltered ? 1 : 0.25}" @click="handleClearFilters">
                <div class="Button Button--cyan">
                    <div class="Button__title">Kõik</div>
                </div>
            </a>
        </div>
        <div class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOfferList" :key="i" :offer="offer" />
        </div>
    </div>
</template>

<script>
import { parseSheets, unique } from '../../utils/utils'

export default {
    props: {
        isclasses: { default: '' },
        route: { default: '' }
    },
    data: () => ({
        offers: [],
        id: '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE',
        activeCompany: -1,
        activeDestination: -1,
        activeStyle: -1,
        activePriceFrom: 0,
        activePriceTo: 0,
        priceRange: 1000,
        round: 10,
        step: 50
    }),
    computed: {
        minPrice() {
            if (this.offers.length) {
                const price = Math.min(...this.offers.map(o => this.convertToNumber(o.price)))
                return Math.floor(price / this.round) * this.round
            }
            return 0
        },
        maxPrice() {
            if (this.offers.length) {
                const price = Math.max(...this.offers.map(o => this.convertToNumber(o.price)))
                return Math.ceil(price / this.round) * this.round
            }
            return 100
        },
        notFiltered() {
            return (
                this.activeCompany == -1 &&
                this.activeDestination == -1 &&
                this.activeStyle == -1 &&
                this.activePriceFrom == this.minPrice &&
                this.activePriceTo == this.maxPrice
            )
        },
        companies() {
            return [
                { id: -1, name: 'Kõik firmad' },
                ...unique(this.offers.map(o => o.user.name)).map((name, id) => ({
                    id,
                    name
                }))
            ]
        },
        destinations() {
            return [
                { id: -1, name: 'Kõik sihtkohad' },
                ...unique(this.offers.map(o => o.end_destinations[0].name)).map((name, id) => ({
                    id,
                    name
                }))
            ]
        },
        styles() {
            return [
                { id: -1, name: 'Kõik reisistiilid' },
                ...unique(this.offers.map(o => o.style)).map((name, id) => ({
                    id,
                    name
                }))
            ]
        },
        filteredOfferList() {
            return this.offers
                .filter(o => {
                    if (this.activeCompany > -1) {
                        return o.user.name == this.getById(this.companies, this.activeCompany, 'name')
                    }
                    return true
                })
                .filter(o => {
                    if (this.activeDestination > -1) {
                        return (
                            o.end_destinations[0].name ==
                            this.getById(this.destinations, this.activeDestination, 'name')
                        )
                    }
                    return true
                })
                .filter(o => {
                    if (this.activeStyle > -1) {
                        return o.style == this.getById(this.styles, this.activeStyle, 'name')
                    }
                    return true
                })
                .filter(o => {
                    return (
                        this.convertToNumber(o.price) >= this.activePriceFrom &&
                        this.convertToNumber(o.price) <= this.activePriceTo
                    )
                })
        }
    },
    methods: {
        convertToNumber(num) {
            return parseFloat(String(num).replace(/[^0-9.]/g, ''))
        },
        getById(data, id, key) {
            if (data.length) {
                return data.filter(d => d.id == id)[0][key]
            }
            return null
        },
        handleClearFilters() {
            this.activeCompany = -1
            this.activeDestination = -1
            this.activeStyle = -1
            this.activePriceFrom = this.minPrice
            this.activePriceTo = this.maxPrice
        }
    },
    mounted() {
        if (this.route) {
            fetch(this.route)
                .then(res => res.json())
                .then(res => {
                    this.offers = res
                    this.activePriceFrom = this.minPrice
                    this.activePriceTo =
                        this.maxPrice < this.minPrice + this.priceRange
                            ? this.minPrice + this.priceRange
                            : this.maxPrice
                })
        }
    }
}
</script>
