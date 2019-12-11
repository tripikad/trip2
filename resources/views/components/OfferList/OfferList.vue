<template>
    <div class="OfferList" :class="isclasses">
        <!--Dotmap :largedots="filteredOffers.map(o => o.coordinates)" /-->

        <form-slider-multiple
            isclasses="FormSliderMultiple--yellow"
            :value="filterState.minPrice"
            @input="price => (filterState.minPrice = price)"
            :value2="filterState.maxPrice"
            @input2="price => (filterState.maxPrice = price)"
            :min="minPrice"
            :max="maxPrice"
            :step="1"
            :suffix="suffix"
        />
        <div class="OfferList__filters">
            <form-select :options="filterOptions.style" v-model="filterState.style" isclasses="FormSelect--blue" />
            <form-select :options="filterOptions.company" v-model="filterState.company" isclasses="FormSelect--blue" />
            <form-select
                :options="filterOptions.destination"
                v-model="filterState.destination"
                isclasses="FormSelect--blue"
            />
            <a @click="resetFilterState">
                <div class="Button Button--cyan">
                    <div class="Button__title">Kõik</div>
                </div>
            </a>
        </div>
        <pre>{{ filterState }}</pre>
        <transition-group name="Fade" class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOffers" :key="offer.id" :offer="offer" :route="offer.route" />
        </transition-group>
        <pre>{{ filterOptions }}</pre>
        <ButtonVue v-if="nextPageUrl" @click.native.prevent="getData" title="Gimme data" />
    </div>
</template>

<script>
import { uniqueFilter, toObject } from '../../utils/utils'
import { filters } from './OfferList'

export default {
    props: {
        isclasses: { default: '' },
        route: { default: '' },
        suffix: { default: '' }
    },
    data: () => ({
        offers: [],
        nextPageUrl: null,
        filterState: toObject(filters.map(({ key }) => [key, 0])),
        minPrice: 0,
        maxPrice: 0
    }),
    computed: {
        filterOptions() {
            return toObject(
                filters
                    .map(({ key, defaultTitle, getId, getTitle }) => {
                        if (getTitle) {
                            const options = uniqueFilter(this.offers, getId)
                                .map(o => ({
                                    id: getId(o),
                                    name: getTitle(o)
                                }))
                                .sort((a, b) => a > b)
                            // We return [key,value] pairs that will be
                            // coverted to { key: value } object by toObject()
                            return [key, [{ id: 0, name: defaultTitle }, ...options]]
                        }
                        return null
                    })
                    .filter(f => f)
            )
        },
        filteredOffers() {
            return filters.reduce(
                (data, { key, getId, compare }) =>
                    data.filter(d => {
                        // If current filter is not enabled
                        // do not filter the data item d,
                        // pass it through

                        if (this.filterState[key] == 0) {
                            return true
                        }

                        // Get the id from the data item
                        // and compare it with current filter
                        // active state

                        return compare(d, this.filterState[key])
                    }),
                this.offers
            )
        }
    },
    methods: {
        getPriceRange() {
            if (this.offers.length) {
                const round = 10
                const prices = this.offers.map(o => parseFloat(o.price))

                return [Math.min(...prices), Math.max(...prices)]
                //.map(price => Math.ceil(price / round) * round)
            }
            return [0, 0]
        },
        getData() {
            if (this.nextPageUrl) {
                this.$http.get(this.nextPageUrl).then(({ data }) => {
                    this.offers = [...this.offers, ...data.data]

                    this.nextPageUrl = data.next_page_url ? data.next_page_url : null

                    // Set min and max prices for the price range silder

                    const [minPrice, maxPrice] = this.getPriceRange()
                    this.minPrice = minPrice
                    this.maxPrice = maxPrice
                })
            }
        },
        resetFilterState() {
            filters.forEach(({ key, getTitle }) => {
                if (getTitle !== null) {
                    this.filterState[key] = 0
                }
            })

            this.filterState.minPrice = this.minPrice
            this.filterState.maxPrice = this.maxPrice
        }
    },
    mounted() {
        // Axios returns the response with "data" property
        // It contains the "data" property (again) and pager
        // information from Laravel paged JSON response

        this.$http.get(this.route).then(({ data }) => {
            // Set the actual data from the response as offers

            this.offers = data.data

            // Set the next page url so getData() method can
            // fetch the data for subsequent pages

            this.nextPageUrl = data.next_page_url

            // Set min and max prices for the price range silder

            const [minPrice, maxPrice] = this.getPriceRange()

            this.minPrice = minPrice
            this.maxPrice = maxPrice

            // Set default min and max price

            this.filterState.minPrice = minPrice
            this.filterState.maxPrice = maxPrice
        })
    }
}
</script>
