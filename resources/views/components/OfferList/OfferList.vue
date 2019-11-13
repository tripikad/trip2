<template>
    <div class="OfferList" :class="isclasses">
        <dotmap
            :dots="dots"
            :activecities="filteredOfferList.map(o => ({lon: parseFloat(o.longitude),lat: parseFloat(o.latitude)}))"
        />
        <!--form-buttons :items="['Kõik','Seiklusreisid','Bussireisid','Pakettreisid']" /-->
        <form-slider-multiple
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
            <form-select placeholder="Reisistiil" :options="styles" v-model="activeStyle" />
            <form-select placeholder="Sihkoht" :options="destinations" v-model="activeDestination" />
            <form-select placeholder="Firma" :options="companies" v-model="activeCompany" />
            <a v-if="!notFiltered" @click="handleClearFilters" class="Button Button--gray">Kõik</a>
        </div>
        <div class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOfferList" :key="i" :offer="offer" />
        </div>
    </div>
</template>

<script>
import { parseSheets, unique } from '../../utils/utils'

/*
->push(
    component('Dotmap')
        ->with('startcity', 829)
        ->with('city', 4654)
        ->with('country', 411)
        ->with('countries', config('dots'))
        ->with('cities', config('cities'))
)
*/
export default {
    props: {
        isclasses: { default: '' },
        route: { default: '' },
        dots: { default: () => [] }
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
                const price = Math.min(
                    ...this.offers.map(o => this.convertToNumber(o.price))
                )
                return Math.floor(price / this.round) * this.round
            }
            return 0
        },
        maxPrice() {
            if (this.offers.length) {
                const price = Math.max(
                    ...this.offers.map(o => this.convertToNumber(o.price))
                )
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
            return unique(this.offers.map(o => o.company)).map((name, id) => ({
                id,
                name
            }))
        },
        destinations() {
            return unique(this.offers.map(o => o.destination)).map(
                (name, id) => ({
                    id,
                    name
                })
            )
        },
        styles() {
            return unique(this.offers.map(o => o.style)).map((name, id) => ({
                id,
                name
            }))
        },
        filteredOfferList() {
            return this.offers
                .filter(o => {
                    if (this.activeCompany > -1) {
                        return (
                            o.company ==
                            this.getById(
                                this.companies,
                                this.activeCompany,
                                'name'
                            )
                        )
                    }
                    return true
                })
                .filter(o => {
                    if (this.activeDestination > -1) {
                        return (
                            o.destination ==
                            this.getById(
                                this.destinations,
                                this.activeDestination,
                                'name'
                            )
                        )
                    }
                    return true
                })
                .filter(o => {
                    if (this.activeStyle > -1) {
                        return (
                            o.style ==
                            this.getById(this.styles, this.activeStyle, 'name')
                        )
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
            return parseFloat(num.replace(/[^0-9.]/g, ''))
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
