<template>
    <div class="OfferList" :class="isclasses">
        <Dotmap :largedots="filteredOffers.map(o => o.coordinates)" isclasses="Dotmap--center" />

        <form-slider-multiple
            isclasses="FormSliderMultiple--yellow"
            :value="filterState.minPrice"
            @input="price => (filterState.minPrice = price)"
            :value2="filterState.maxPrice"
            @input2="price => (filterState.maxPrice = price)"
            :min="minPrice"
            :max="maxPrice"
            :step="step"
            :suffix="suffix"
        />

        <div class="OfferList__filters">
            <form-buttons
                v-model="filterState.date"
                :items="dateOptions"
                isclasses="FormButtons--blue FormButtons--wide"
            />

            <form-buttons
                :items="filterOptions.style"
                v-model="filterState.style"
                isclasses="FormButtons--blue FormButtons--wide"
            />

            <div class="OfferList__filtersRow">
                <form-select
                    :options="filterOptions.company"
                    v-model="filterState.company"
                    isclasses="FormSelect--blue"
                />
                <form-select
                    :options="filterOptions.destination"
                    v-model="filterState.destination"
                    isclasses="FormSelect--blue"
                />
            </div>
            <div class="OfferList__filtersReset">
                <!-- @TODO2 translate title -->
                <ButtonVue
                    title="Näita kõiki reise"
                    @click.native.prevent="resetFilterState"
                    isclasses="Button--small Button--cyan Button--narrow"
                    :style="{ opacity: offers.length == 0 || offers.length == filteredOffers.length ? 0 : 1 }"
                />
            </div>
        </div>

        <transition-group name="Fade" class="OfferList__offers">
            <OfferRow v-for="offer in filteredOffers" :key="offer.id" :offer="offer" :route="offer.route" />
        </transition-group>
        <!-- @TODO2 Translate title -->
        <ButtonVue v-if="nextPageUrl" @click.native.prevent="getData" title="Näita hilisemaid reise" />
    </div>
</template>

<script>
import { uniqueFilter, toObject, seasonRange, formatSeasonRange } from '../../utils/utils'
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
        filterState: toObject(filters.map(({ key, defaultState }) => [key, 0])),
        minPrice: 0,
        maxPrice: 0,
        // @TODO2 translate title
        dateOptions: ['Kõik aastaajad', ...formatSeasonRange(seasonRange(new Date()))],
        step: 100
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

                return [Math.min(...prices), Math.max(...prices)].map(
                    (price, i) => Math[['floor', 'ceil'][i]](price / this.step) * this.step
                )
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
            this.filterState.date = 0
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
