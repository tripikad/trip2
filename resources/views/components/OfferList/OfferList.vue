<template>
    <div class="OfferList" :class="isclasses">
        <!--Dotmap :largedots="filteredOffers.map(o => o.coordinates)" /-->
        <form-select :options="filterOptions.style" v-model="filterState.style" isclasses="FormSelect--blue" />
        <form-select :options="filterOptions.company" v-model="filterState.company" isclasses="FormSelect--blue" />
        <!--
        <pre
            >{{ filterState }}
---
{{ filterOptions }}
        </pre>
        -->
        <div class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOffers" :key="i" :offer="offer" :route="offer.route" />
        </div>
        <ButtonVue v-if="nextPageUrl" @click.native.prevent="getData" title="Gimme data" />
    </div>
</template>

<script>
import { uniqueFilter, toObject } from '../../utils/utils'

const filters = [
    {
        key: 'company',
        getId: o => o.user.id,
        result: o => ({ id: o.user.id, name: o.user.name })
    },
    {
        key: 'style',
        getId: o => o.style,
        result: o => ({ id: o.style, name: o.style })
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
                filters.map(({ key, getId, result }) => {
                    return [key, uniqueFilter(this.offers, getId).map(result)]
                })
            )
        },
        filteredOffers() {
            return filters.reduce(
                (data, { key, getId }) =>
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

                        return getId(d) == this.filterState[key]
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
