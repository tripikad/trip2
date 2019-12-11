<template>
    <div class="OfferList" :class="isclasses">
        <!--Dotmap :largedots="filteredOffers.map(o => o.coordinates)" /-->
        <form-select :options="filterOptions.style" v-model="filterState.style" isclasses="FormSelect--blue" />
        <form-select :options="filterOptions.company" v-model="filterState.company" isclasses="FormSelect--blue" />
        <pre>{{ filterState }}</pre>
        <div class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOffers" :key="i" :offer="offer" :route="offer.route" />
        </div>
        <pre>{{ filterOptions }}</pre>
        <ButtonVue v-if="nextPageUrl" @click.native.prevent="getData" title="Gimme data" />
    </div>
</template>

<script>
import { uniqueFilter, toObject } from '../../utils/utils'

const filters = [
    {
        key: 'company',
        defaultTitle: 'Kõik reisifirmad',
        getId: o => o.user.id,
        getTitle: o => o.user.name,
        compare: (o, filterState) => o.user.id == filterState
    },
    {
        key: 'style',
        defaultTitle: 'Kõik reisistiilid',
        getId: o => o.style,
        getTitle: o => o.style_formatted,
        compare: (o, filterState) => o.style == filterState
    },
    {
        key: 'minPrice',
        defaultTitle: 'Minimaalne hind',
        getId: o => o.price,
        getTitle: null
    }
]

const intialFilterState = toObject(filters.map(({ key }) => [key, -1]))

export default {
    props: {
        isclasses: { default: '' },
        route: { default: '' }
    },
    data: () => ({
        offers: [],
        nextPageUrl: null,
        filterState: intialFilterState
    }),
    computed: {
        filterOptions() {
            return toObject(
                filters
                    .map(({ key, defaultTitle, getId, getTitle }) => {
                        if (getTitle) {
                            const options = uniqueFilter(this.offers, getId).map(o => ({
                                id: getId(o),
                                name: getTitle(o)
                            }))
                            // We return [key,value] pairs that will be
                            // coverted to { key: value } object by toObject()
                            return [key, [{ id: -1, name: defaultTitle }, ...options]]
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

                        if (this.filterState[key] == -1) {
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
        getData() {
            if (this.nextPageUrl) {
                this.$http.get(this.nextPageUrl).then(({ data }) => {
                    this.offers = [...this.offers, ...data.data]
                    this.nextPageUrl = data.next_page_url ? data.next_page_url : null
                })
            }
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
        })
    }
}
</script>
